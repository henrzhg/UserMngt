<?php
class UserService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByID(int $id) {
        
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? Limit 1");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_object();

            return $user;
        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=>$e->getCode()
            );
        }
    }

    public function getAllUsers(int $limit, int $offset) {
        try {

            if ($limit < 0 || $limit < 20 ) {
                $limit = 20;
            }

            $stmt = $this->db->prepare("SELECT * FROM users LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
            return $users;

        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=>$e->getCode()
            );
        }
    }

    public function getUserByEmail(string $email) {

        try {
            $email = trim($email);
            if (empty($email)) {
                throw new Exception("Email is not valid", 404);
            } 

            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? limit 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception("No user found with email {$email}", 404);
            }

            $user = $result->fetch_object();

            return $user;

        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=>$e->getCode()
            );
        }
    }

    public function createUser($params) {
        $this->db->begin_transaction();

        try {
            $requiredField = 'name,email';
            $requiredField = explode(',', $requiredField);

            foreach ($requiredField as $key => $value) {
                if(empty($params[$key])) {
                    throw new Exception("Field {$key} is required", 400);
                }

                $value = trim($value);
                if (!is_string($value)) {
                    throw new Exception("Field {$key} must be a valid string", 400);
                }

                $params[$key] = $value;
            }

            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? limit 1");
            $stmt->bind_param("s", $params["email"]);
            $stmt->execute();
            $userExists = $stmt->get_result();
            if (!empty($userExists)){
                throw new Exception("Email {$params["email"]} already exists", 400);
            }

            $stmt = $this->db->prepare("INSERT INTO user(name, email) VALUES (?,?)");
            $stmt->bind_param("ss", $params["name"], $params["email"]);
            $stmt->execute();

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollback();
            return array(
                "error"=>$e->getMessage(),
                "error_code"=>$e->getCode()
            );
        }
    }
}

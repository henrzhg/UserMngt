<?php
class UserController {
    private UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function getUser($id) {
        try {
            if (!is_int($id)){
                throw new Exception("User Id must be a valid number", 400);
            }

            $result = $this->service->getUserByID($id);

            return $result;
        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=> $e->getCode()
            );
        }
    }

    public function getUserByEmail($email) {
        try {
            if (!is_string($email)){
                throw new Exception("User Id must be a valid string", 400);
            }

            $result = $this->service->getUserByEmail($email);

            return $result;
        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=> $e->getCode()
            );
        }
    }

    public function getAllUsers($limit, $offset) {
        try {
            if (!is_int($limit) || !is_int($offset)){
                throw new Exception("Limit and Offset must be a valid number", 400);
            }

            $result = $this->service->getAllUsers($limit, $offset);

            return $result;
        } catch (Exception $e) {
            return array(
                "error"=>$e->getMessage(),
                "error_code"=> $e->getCode()
            );
        }
    }
}

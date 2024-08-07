<?php
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase {
    protected $userService;

    protected function setUp(): void {
        $this->userService = new UserService();
    }

    public function testGetUserByEmail() {
        $email = "test@example.com";
        $user = $this->userService->getUserByEmail($email);
        $this->assertIsArray($user);
        $this->assertEquals($email, $user['email']);
    }

    public function testGetAllUsers() {
        $limit = 10;
        $offset = 0;
        $users = $this->userService->getAllUsers($limit, $offset);
        $this->assertIsArray($users);
        $this->assertCount($limit, $users);
    }
}

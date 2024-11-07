<?php
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Company;
use App\Models\Department;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase; // This will automatically migrate the database before each test

    protected $helper;
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new TeHelper();
        $this->userService = app(UserRepository::class); // Get the UserService class instance
      
        
    }


    public function testCreateOrUpdateNewUser()
    {
        // Simulate request data for creating a user
        $request = [
            'role' => 'customer',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'dob_or_orgid' => '123456',
            'phone' => '1234567890',
            'mobile' => '9876543210',
            'password' => 'secret',
            'consumer_type' => 'paid',
            'company_id' => '',
            'department_id' => '',
            'customer_type' => 'regular',
            'username' => 'johndoe',
            'post_code' => '12345',
            'address' => '123 Main St',
            'city' => 'City',
            'town' => 'Town',
            'country' => 'Country',
            'reference' => 'yes',
            'additional_info' => 'Test info'
        ];

        // Simulate the createOrUpdate logic in your controller or service
        $this->userService->createOrUpdate(null, $request); // Passing null for creating new user

        // Retrieve the user from the database
        $user = User::where('email', 'john.doe@example.com')->first();

        // Assert that the user was created
        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);

        // Assert user roles are attached
        $this->assertTrue($user->hasRole('customer'));

        // Check the UserMeta data
        $userMeta = UserMeta::where('user_id', $user->id)->first();
        $this->assertNotNull($userMeta);
        $this->assertEquals('paid', $userMeta->consumer_type);
        $this->assertEquals('regular', $userMeta->customer_type);
        $this->assertEquals('Test info', $userMeta->additional_info);
    }

    public function testCreateOrUpdateExistingUser()
    {
        // First, create a user
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'role' => 'customer'
        ]);

        // Simulate request data for updating the user
        $request = [
            'role' => 'customer',
            'name' => 'Jane Smith',
            'email' => 'jane.doe@example.com',
            'dob_or_orgid' => '123456',
            'phone' => '1234567890',
            'mobile' => '9876543210',
            'password' => 'newpassword',
            'consumer_type' => 'free',
            'company_id' => '',
            'department_id' => '',
            'customer_type' => 'regular',
            'username' => 'janesmith',
            'post_code' => '54321',
            'address' => '456 Secondary St',
            'city' => 'Another City',
            'town' => 'Another Town',
            'country' => 'Another Country',
            'reference' => 'no',
            'additional_info' => 'Updated info'
        ];

        // Simulate the createOrUpdate logic in your controller or service
        $this->userService->createOrUpdate($user->id, $request); // Pass the existing user's ID to update it

        // Retrieve the updated user from the database
        $updatedUser = User::find($user->id);

        // Assert that the user's name is updated
        $this->assertEquals('Jane Smith', $updatedUser->name);

        // Check that the UserMeta data was also updated
        $userMeta = UserMeta::where('user_id', $updatedUser->id)->first();
        $this->assertNotNull($userMeta);
        $this->assertEquals('free', $userMeta->consumer_type);
        $this->assertEquals('regular', $userMeta->customer_type);
        $this->assertEquals('Updated info', $userMeta->additional_info);
    }
}

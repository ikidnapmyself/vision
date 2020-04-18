<?php

namespace Tests\Unit;

use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * User service.
     * @var UserServiceInterface $service
     */
    protected UserServiceInterface $service;

    /**
     * User model.
     * @var User $user
     */
    protected User $user;

    /**
     * Setup testing
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = resolve(UserServiceInterface::class);
        $this->user    = factory(User::class)->create()->fresh();
    }


    /**
     * Testing find method.
     *
     * @return void
     */
    public function testFind()
    {
        $find = $this->service->find($this->user->id);

        $this->assertEquals($this->user, $find);
    }

    /**
     * Testing findByEmail method.
     *
     * @return void
     */
    public function testFindByEmail()
    {
        $find = $this->service->findByEmail($this->user->email);

        $this->assertEquals($this->user, $find);
    }

    /**
     * Testing index method.
     *
     * @return void
     */
    public function testIndex()
    {
        factory(User::class, 30)->create();
        $index = $this->service->index();

        $this->assertEquals(31, $index->total());
    }

    /**
     * Testing show method by comparing email addresses.
     *
     * @return void
     */
    public function testShow()
    {
        $show = $this->service->show($this->user->id);

        $this->assertEquals($this->user->email, $show->email);
    }

    /**
     * Testing update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        $backup = $this->user;
        $new    = factory(User::class)->make();
        $fields = $new->only(['name', 'surname', 'email']);

        $update = $this->service->update($this->user->id, $fields);

        $this->assertNotEquals($backup->full_name, $update->full_name);
        $this->assertNotEquals($backup->email, $update->email);
        $this->assertEquals($new->full_name, $update->full_name);
        $this->assertEquals($new->email, $update->email);
    }
}

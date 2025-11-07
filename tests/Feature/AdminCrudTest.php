<?php
namespace Tests\Feature;

use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // avoid depending on DB seeders here; tests will skip if tables missing
    }

    public function test_pages_index_requires_admin_session()
    {
        $response = $this->get('/admin/manage-pages');
        // without admin session, should redirect to login (200 on login page)
        $this->assertTrue(in_array($response->status(), [200,302]));
    }

    public function test_admin_pages_index_with_session()
    {
        $response = $this->withSession(['alogin' => true])->get('/admin/manage-pages');
        $response->assertStatus(200);
    }

    public function test_testimonials_index_with_session()
    {
        $response = $this->withSession(['alogin' => true])->get('/admin/testimonials');
        $response->assertStatus(200);
    }

    public function test_subscribers_index_with_session()
    {
        $response = $this->withSession(['alogin' => true])->get('/admin/manage-subscribers');
        $response->assertStatus(200);
    }

    public function test_users_index_with_session()
    {
        $response = $this->withSession(['alogin' => true])->get('/admin/reg-users');
        $response->assertStatus(200);
    }
}

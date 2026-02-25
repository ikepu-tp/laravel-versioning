<?php

namespace Tests\Feature;

use Tests\TestCase;

class VersioningEditorMiddlewareTest extends TestCase
{
    private string $versionJsonPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->versionJsonPath = base_path('version.json');
        // Ensure a clean version.json exists for tests that reach the controller
        file_put_contents($this->versionJsonPath, json_encode([]));
    }

    protected function tearDown(): void
    {
        if (file_exists($this->versionJsonPath)) {
            unlink($this->versionJsonPath);
        }
        parent::tearDown();
    }

    /**
     * @test
     * ミドルウェア - ローカル環境 - 正常
     */
    public function test_allows_access_in_local_environment(): void
    {
        // app env is 'local' by default in TestCase
        $response = $this->get(route('version.editor.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * ミドルウェア - 非ローカル・認証なし - 異常
     */
    public function test_rejects_unauthenticated_user_in_non_local(): void
    {
        $this->app['env'] = 'production';

        $response = $this->get(route('version.editor.index'));
        $response->assertStatus(401);
    }

    /**
     * @test
     * ミドルウェア - 非ローカル・許可IDあり - 正常
     */
    public function test_allows_user_with_permitted_id(): void
    {
        $this->app['env'] = 'production';
        $this->app['config']->set('versioning.editor_user_ids', '1');

        $user = new \Illuminate\Foundation\Auth\User();
        $user->id = 1;
        $user->email = 'other@example.com';

        $response = $this->actingAs($user)->get(route('version.editor.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * ミドルウェア - 非ローカル・許可メールあり - 正常
     */
    public function test_allows_user_with_permitted_email(): void
    {
        $this->app['env'] = 'production';
        $this->app['config']->set('versioning.editor_emails', 'admin@example.com');

        $user = new \Illuminate\Foundation\Auth\User();
        $user->id = 999;
        $user->email = 'admin@example.com';

        $response = $this->actingAs($user)->get(route('version.editor.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * ミドルウェア - 非ローカル・許可なし - 異常
     */
    public function test_rejects_user_without_permission(): void
    {
        $this->app['env'] = 'production';
        $this->app['config']->set('versioning.editor_user_ids', '1,2,3');
        $this->app['config']->set('versioning.editor_emails', 'admin@example.com');

        $user = new \Illuminate\Foundation\Auth\User();
        $user->id = 999;
        $user->email = 'nobody@example.com';

        $response = $this->actingAs($user)->get(route('version.editor.index'));
        $response->assertStatus(401);
    }
}

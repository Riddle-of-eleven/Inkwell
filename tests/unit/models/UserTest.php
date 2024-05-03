<?php

namespace tests\unit\models;

use app\models\Tables\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = User::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(\app\models\Tables\User::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = \app\models\Tables\User::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(\app\models\Tables\User::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = \app\models\Tables\User::findByUsername('admin'))->notEmpty();
        verify(\app\models\Tables\User::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}

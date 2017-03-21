<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/5/19
 * Time: 13:56
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @var
     * @SecurityAssert\UserPassword(message="Wrong value for your current password")
     */
    public $oldPassword;

    /**
     * @var
     * @Assert\Length(min="6",minMessage="password should at least 6 chars long")
     */
    public $newPassword;


}
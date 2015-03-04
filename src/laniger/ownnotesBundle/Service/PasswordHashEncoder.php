<?php
namespace laniger\ownnotesBundle\Service;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Encoder service which uses password_hash as encoding method
 * @author laniger
 */
class PasswordHashEncoder implements PasswordEncoderInterface
{

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface::encodePassword()
     */
    public function encodePassword($raw, $salt)
    {
        return password_hash($raw, PASSWORD_DEFAULT);
    }

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface::isPasswordValid()
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return password_verify($raw, $encoded);
    }
}
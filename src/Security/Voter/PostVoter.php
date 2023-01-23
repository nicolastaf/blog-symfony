<?php
// src/Security/PostVoter.php
namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PostVoter extends Voter
{
    // these strings are just invented: you can use anything
    const DELETE = 'delete';
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Post) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete();
                break;
            case self::EDIT:
                    return $this->canEdit();
                break;
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(): bool
    {
        // // if they can edit, they can view
        // if ($this->canEdit($post, $user)) {
        //     return true;
        // }

        // // the Post object could have, for example, a method `isPrivate()`
        // return false;
        return $this->security->isGranted('ROLE_ADMIN');
    }

    private function canEdit(): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        return $this->security->isGranted('ROLE_ADMIN');
    }
}
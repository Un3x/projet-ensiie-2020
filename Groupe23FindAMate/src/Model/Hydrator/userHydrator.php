<?
namespace Hydrator;
use \Entity\User as User;
class UserHydrator{
    public function hydrate($data)
    {
        $topic=new User();
        $topic
            ->setId($data['utilisateurid'])
            ->setEmail($data['email'])
            

    }
}

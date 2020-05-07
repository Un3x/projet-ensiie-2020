<?php

namespace Admin;

class AdminRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }


        public function fetchAdmin2()
        {
            $adminsData = $this->dbAdapter->query("SELECT Administrateur.Id_MembreA, Membre.username ,  Association.Nom_assoc, Administrer.Id_assoc  FROM Administrateur
                                                        join Membre on Administrateur.Id_MembreA = Membre.id
                                                        join Administrer on Administrateur.Id_MembreA = Administrer.Id_Membre
                                                        join Association on Administrer.Id_Assoc = Association.Id_Assoc");
            $admins = [];
            foreach ($adminsData as $adminsDatum) {
                $admin = new Admin();
                $admin
                    ->setId_MembreA($adminsDatum['id_membrea'])
                    ->setUsername($adminsDatum['username'])
                    ->setId_assoc($adminsDatum['id_assoc'])
                    ->setNom_assoc($adminsDatum['nom_assoc']);
                $admins[] = $admin;
            }
            return $admins;
            }
}

?>
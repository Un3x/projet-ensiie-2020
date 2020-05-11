<?php
session_start()
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
?>

<h1>Gestion de vos playlists :</h1></br>
<?php

  include 'Playlist/Playlist.php';
  include 'Playlist/PlaylistRepository.php';
  include 'Factory/DbAdaperFactory.php';
  
  if (isset($_SESSION['username']) && isset($_SESSION['id'])
  {
  $creator=htmlspecialchars($_SESSION['username']);
  $playlists=getPlaylist($creator);
  echo '<a href="createPlaylist.php">Créer une playlist</a></br>';
  if(pg_num_rows($playlists))
    {
    echo '<table>'
    while($row=pg_fetch_array($playlists)
      {
      echo '<tr>';
      echo '<td>'.$row["name"].'</td>';
      echo '<td>'.$row["publik"].'</td>';
      echo '<td><a=href"supprPlaylist.php?name=$row['name']&creator=$row['creator']">Supprimer la playlist</a></td>'
      echo '<td><a=href"showPlaylist.php?name=$row['name']&creator=$row['creator']">Modifier le contenu</td>'
      echo '</tr>';
      }
    echo '</table>';
    }
  }
  else
  {
  header("Location : ../../../public/login.php");
  }
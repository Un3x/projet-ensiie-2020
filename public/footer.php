
<!-- Pied de page -->
</br>
</br>
<button type="button" onclick="document.getElementById('dcnt').style.display='block'">Deconnexion</button></br>
<form id="dcnt" action="/deconnect.php" style="display:none">
    Etes vous sûr de vouloir vous déconnecter ?
    <button type="button" onclick="document.getElementById('dcnt').style.display='none'">non</button>
    <button type="submit">oui</button>
</form>
	<footer>
		<p>
			copyright &copy; Ougali - <?php echo date('Y'); ?> All Right reserved
		</p>
		
	</footer>
</body>
</html>

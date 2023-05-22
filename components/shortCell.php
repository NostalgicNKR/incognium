<?php
if(isset($_GET['alias'])) {
$shortLink ="http://".$_SERVER['HTTP_HOST'].parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)."s/".$_GET['alias'];
    ?>

<div class="hero-form newsletter-form field field-grouped is-revealing">	 		
        <div class="control control-expanded">
        <form action="saveLink.php" id="submit-link">		
            <input class="input" id="urlinput" type="url" name="url" value="<?= $shortLink ?>" placeholder="Paste link to shorten">
            </form>
        </div>
        <div class="control">
            <button class="button button-primary button-block button-shadow" onclick="clearLink()" >Short Another Link</button>
        </div>
</div>

<script>
    function clearLink() {

        window.location.href = window.location.href.split('?')[0];
    }
</script>

<?php $qrURL = 'https://chart.apis.google.com/chart?cht=qr&chs=300x300&chl='.$shortLink; ?>
<div class="container newsletter-form is-revealing mt-3 ">
<div class="btn-group mb-3" role="group" aria-label="Basic example">
  <button type="button" class="button button-primary button-shadow" onclick="copyIt()">Copy Link</button>
  <button type="button" class="button btn-primary button-shadow" onclick="downloadQR('<?= $qrURL ?>')">Download QR</button>
</div>
<center><img style="width:250px;" class="qrimg" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo $shortLink; ?>"></center>
</div>
<script>
async function downloadQR(imageSrc) {
  const image = await fetch(imageSrc)
  const imageBlog = await image.blob()
  const imageURL = URL.createObjectURL(imageBlog)

  const link = document.createElement('a')
  link.href = imageURL
  link.download = '<?= $slug ?>-QR'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}
</script>

<?php } else { ?>
<div class="hero-form newsletter-form field field-grouped is-revealing">	 		
        <div class="control control-expanded">
        <form action="saveLink.php" id="submit-link">		
            <input class="input" id="urlinput" type="url" name="url" placeholder="Paste link to shorten">
            </form>
        </div>
        <div class="control">
            <button class="button button-primary button-block button-shadow" form="submit-link" type="submit">Make Anonymous</button>
        </div>
</div>
<?php } ?>

<div id="changelog-content"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/2.0.1/remarkable.min.js"></script>
<script>
  const content = document.getElementById("changelog-content");
  
  const { Remarkable } = window.remarkable;
  const md = new Remarkable();

  fetch('https://raw.githubusercontent.com/IIP-Design/social-link-optimizer/main/CHANGELOG.md')
    .then( response => response.text() )
    .then( data => content.innerHTML = md.render( data ) )
</script>

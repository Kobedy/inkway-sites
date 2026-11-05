<?php
/**
 * Section « fidelite » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="fid" id="fidelite"><div class="wrap">
  <div><span class="kick" style="color:var(--accent-l)">Carte de fidélité</span><h2 data-reveal>9 coupes,<br>la 10<sup>e</sup> est <span class="script">offerte.</span></h2>
    <p class="sub">Demandez votre carte au salon. À chaque coupe, un tampon. Après neuf coupes, la dixième est pour nous. Touchez les cases pour voir le principe.</p></div>
  <div class="lcard" data-loyalty data-reveal>
    <div class="lhead"><span class="brand"><img src="<?php echo esc_url( pken_logo_url() ); ?>" alt=""><span><b>PKEN Coiffure</b></span></span><span>Carte de fidélité</span></div>
    <div class="stamps"><button class="stamp">1</button><button class="stamp">2</button><button class="stamp">3</button><button class="stamp">4</button><button class="stamp">5</button><button class="stamp">6</button><button class="stamp">7</button><button class="stamp">8</button><button class="stamp">9</button><button class="stamp gift">10<br>offerte</button></div>
    <p data-loyalty-out>9 coupes, la 10e offerte</p>
  </div>
</div></section>

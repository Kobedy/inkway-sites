<?php
/**
 * Section « rendez-vous » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="rdv" id="rdv"><div class="wrap">
  <div><span class="kick">Rendez-vous</span><h2 data-reveal>Réservez en <span class="script" style="color:var(--accent)">1 minute.</span></h2>
    <p class="sub">Votre demande part directement sur le WhatsApp du salon.</p>
    <div class="how">
      <div><b class="n">1</b><span><b>Choisissez</b><p>La prestation, le jour et l’heure qui vous arrangent.</p></span></div>
      <div><b class="n">2</b><span><b>Envoyez</b><p>Votre demande s’ouvre dans WhatsApp, prête à envoyer.</p></span></div>
      <div><b class="n">3</b><span><b>Confirmation</b><p>Le salon vous confirme votre créneau par message.</p></span></div>
    </div>
  </div>
  <div class="panel">
    <form data-booking data-whatsapp="<?php echo esc_attr( pken_opt( 'whatsapp' ) ); ?>" data-salon="<?php echo esc_attr( pken_opt( 'brand' ) ); ?>" data-step="30">
      <label class="field full">Prestation<select name="service" required><option value="">Choisir une prestation</option><?php pken_service_options(); ?></select></label>
      <label class="field">Date<input type="date" name="date" required></label>
      <label class="field">Heure<select name="time" required></select></label>
      <label class="field full">Nom et prénom<input name="name" required autocomplete="name"></label>
      <label class="field full">Précision (facultatif)<textarea name="note" rows="2" placeholder="Ex. coupe pour deux personnes"></textarea></label>
      <div class="full recap" aria-live="polite">
        <div class="recap-head"><b>Récapitulatif</b><span class="recap-price" data-sum="price">—</span></div>
        <dl>
          <dt>Prestation</dt><dd data-sum="service">—</dd>
          <dt>Date</dt><dd data-sum="date">—</dd>
          <dt>Créneau</dt><dd data-sum="time">—</dd>
          <dt>Nom</dt><dd data-sum="name">—</dd>
          <dt data-sum-row="note" hidden>Précision</dt><dd data-sum="note" data-sum-row="note" hidden>—</dd>
        </dl>
      </div>
      <div class="full"><button class="btn" type="submit" style="width:100%">Envoyer ma demande</button></div>
      <p class="full small" style="margin:0">Le rendez-vous est confirmé uniquement après la réponse du salon. Vous pouvez aussi appeler le <a href="<?php echo esc_url( pken_tel_href() ); ?>"><?php echo esc_html( pken_opt( 'phone' ) ); ?></a>. Vos informations ne sont pas enregistrées par le site : <a href="<?php echo esc_url( pken_page_url( 'confidentialite' ) ); ?>">confidentialité</a>.</p>
    </form>
  </div>
</div></section>

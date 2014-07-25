<footer class="content-info " role="contentinfo">
  <div class="row">
    <div class="col-lg-12">
      <span id="footer_info_button" class="glyphicon glyphicon-info-sign"></span>
    </div>
  </div>
  <div class="row reveal">
    <div class="col-lg-12">
      <?php dynamic_sidebar('sidebar-footer'); ?>
        <div class="contact_info email"><span class="email_symbol">@</span><a href="mailto:nancy.goldring@gmail.com" target="_blank">nancy.goldring@gmail.com</a></div>
        <div class="contact_info phone"><span class="glyphicon glyphicon-earphone"></span>(212) 123-4567</div>
        <div class="contact_info envelope"><span class="glyphicon glyphicon-envelope"></span>463 West St., A1112, New York, NY 10014</div>
      <div class="copyright"><span class="glyphicon glyphicon-copyright-mark"></span> <?php echo date('Y'); ?> <?php bloginfo('name'); ?></div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>

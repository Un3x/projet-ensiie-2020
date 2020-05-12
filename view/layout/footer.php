<footer class="page-footer font-small bg-dark mt-4">
    <div class="footer text-center py-4">© 2020 <img src="/favicon.png" alt="Logo" /> Ada
        <br>
        <div class="badge badge-secondary">Process time <?php echo number_format(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3)*1000; ?>ms</div>
        <br>
        <a href="https://getbootstrap.com/"><div class="badge badge-secondary mx-1" style="background: #563d7c">Bootstrap</div></a>
        <a href="https://fontawesome.com/"><div class="badge badge-secondary mx-1" style="background: #228be6">Font Awesome</div></a>
        <a href="https://www.adminer.org/"><div class="badge badge-secondary mx-1" style="background: #19448D">Adminer</div></a>
        <a href="https://twitter.github.io/typeahead.js/"><div class="badge badge-secondary mx-1" style="background: #00ACED">Typeahead</div></a>
        <a href="https://parsedown.org/"><div class="badge badge-secondary mx-1" style="background: #586069">Parsedown</div></a>
        <a href="https://github.com/samayo/bulletproof"><div class="badge badge-secondary mx-1" style="background: #586069">Bulletproof</div></a>
        <a href="https://emoji-button.js.org/"><div class="badge badge-secondary mx-1" style="background: #f9b200">Emoji Button</div></a>
    </div>
</footer>
<style>
    .footer {
        border-top: 4px solid #6020a0;
        background-color: #32383E;
    }

    .footer .badge {
        text-transform: uppercase;
    }
</style>
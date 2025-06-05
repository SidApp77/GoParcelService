<style>
    .top-right-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
        transition: opacity 0.5s;
    }
</style>

@if (Session::has('success'))
    <div class="alert alert-success top-right-alert">
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger top-right-alert">
        {{ Session::get('error') }}
    </div>
@endif

<script>
    setTimeout(function() {
        document.querySelectorAll('.top-right-alert').forEach(function(el) {
            el.style.opacity = '0';
            setTimeout(function() { el.style.display = 'none'; }, 500);
        });
    }, 3000);
</script>
<template>
    <aside class="col-md-4 blog-sidebar">
        <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>

        <archives-list></archives-list>

        <div class="p-3">
            <h4 class="font-italic">Elsewhere</h4>
            <ol class="list-unstyled">
                <li><a href="https://github.com/iceking2nd">GitHub</a></li>
                <li><a href="https://twitter.com/iceking2nd">Twitter</a></li>
                <li><a href="https://www.facebook.com/iceking2nd">Facebook</a></li>
            </ol>
        </div>
    </aside><!-- /.blog-sidebar -->
</template>

<script>
    import ArchivesList from './archives-list'

    export default {
        components:{
            ArchivesList
        }
    }
</script>

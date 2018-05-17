<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">修改资料</div>

            <div class="card-body">
                <profile-edit-form></profile-edit-form>
            </div>
        </div>
    </div>
</template>

<script>
    import ProfileEditForm from './ProfileEditForm'

    export default {
        name: 'profile-edit',
        components:{
            ProfileEditForm
        }
    }
</script>

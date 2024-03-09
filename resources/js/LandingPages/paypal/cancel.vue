<template>
    <!-- cancel -->
    <div class="container mt-5 py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Transaction Cancelled!</h4>
                    <p>Your transaction has been cancelled. Please try again.</p>
                    <hr />
                    <p class="mb-0">
                        <a href="/" class="btn btn-primary">Go Back</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: this.$route.query.token,
        };
    },
};
</script>

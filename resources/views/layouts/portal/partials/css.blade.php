<!-- CSS FILES -->
<link rel="stylesheet" href="{{ asset('portal/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('portal/css/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('portal/css/templatemo-kind-heart-charity.css') }}">
<style>
    .required:after {
        content: " *";
        color: red;
    }

    .news-image {
        object-fit: cover;
        /* height: 500px; */
        width: 100%;
    }

    .news-image.small {
        object-fit: cover;
        /* height: 200px; */
        width: 100%;
    }

    .news-block-body img {
        width: 50%;
        height: 50%;
    }

    .whatsapp-fab {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #25D366;
        /* WhatsApp green color */
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        text-decoration: none;
        z-index: 1000;
        /* Ensure it's above other elements */
        transition: background-color 0.3s ease;
    }

    .whatsapp-fab:hover {
        background-color: #128C7E;
        /* Darker shade on hover */
    }

    .whatsapp-icon {
        width: 40px;
        height: 40px;
    }

    .volunteer-section {
        background-image: url({{ asset('images/bg.jpeg') }});
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .consultation-container {
        z-index: 1;
        position: relative;
    }

    .login-section {
        background-image: url({{ asset('images/bg.jpeg') }});
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-top: 150px;
        padding-bottom: 150px;
    }

    .job-image {
        object-fit: cover;
        max-height: 250px;
        min-height: 250px;
        width: 100%;
    }

    .custom-btn.auth {
        background-image: url({{ asset('images/gradient.webp') }});
        rackground-repeat: no-repeat;
        background-position: left;
    }

    .custom-block-wrap {
        height: 100%;
        /* min-height: 200px; */
    }
</style>

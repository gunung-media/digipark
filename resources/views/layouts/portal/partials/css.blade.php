<!-- CSS FILES -->
<link rel="stylesheet" href="{{ asset('portal/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('portal/css/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('portal/css/templatemo-kind-heart-charity.css') }}">
<style>
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
        height: 250px;
        width: 100%;
    }

    .custom-btn.auth {
        background-image: url({{ asset('images/gradient.webp') }});
        rackground-repeat: no-repeat;
        background-position: left;
    }
</style>

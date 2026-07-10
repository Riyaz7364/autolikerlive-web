<style>
    .ad-block-right-336X280 {
        max-width: 300px;
        margin-right: -50px;
    }

    .ad-block-336X280 {
        max-height: 247px !important;
        position: relative;
    }


    .ads-box {
        font-size: 0;
    }

    .mail-wrapper {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: center;
        margin-top: 0px;
        flex-wrap: nowrap;
    }

    @media (max-width: 1200px) {
        .mail-wrapper {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }
    }

    .mail-wrapper .ad {
        -ms-flex-negative: 0;
        flex-shrink: 0;
    }

    @media (max-width: 1200px) {
        .mail-wrapper .ad:first-child {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 1200px) {
        .mail-wrapper .ad:last-child {
            margin-top: 20px;
        }
    }

    .mail-wrapper .mail-selection {
        max-width: 750px;
        width: 100%;
        border-radius: 10px;
        padding: 15px 10px;
        /*margin-right: auto;
                    margin-left: auto;
                    */
        margin: 0 15px;
        -ms-flex-negative: 1;
        flex-shrink: 1;
    }



    .mail-wrapper .mail-selection .mail-select {
        position: relative;
        z-index: 50;
    }

    .mail-wrapper .mail-selection .mail-select .mail-input {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .mail-wrapper .mail-selection .mail-select .mail-input input {
        outline: 0;
        border: 0;
        border-radius: 8px;
        padding: 10px 80px 10px 20px;
        font-weight: 500;
        font-size: 18px;
        height: 70px;
        width: 100%;
        cursor: pointer;
        -webkit-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
        background-color: #f8f9fa;
    }

    @media (max-width: 991.98px) {
        .mail-wrapper .mail-selection .mail-select .mail-input input {
            height: 55px;
        }
    }

    .mail-wrapper .mail-selection .mail-select .mail-input .mail-input-copy {
        position: absolute;
        right: 8px;
        height: 80%;
        width: 60px;
        font-size: 18px;
    }

    .mail-wrapper .mail-selection .mail-select .mail-input .mail-input-icon {
        position: absolute;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        right: 80px;
        font-size: 16px;
        color: var(--text_color);
        cursor: pointer;
        border: 2px solid var(--text_color);
        border-radius: 50%;
        width: 26px;
        height: 26px;
    }

    .mail-wrapper .mail-selection .mail-select .mail-results {
        visibility: hidden;
        position: absolute;
        width: 100%;
        background-color: #f6f6f6;
        border-radius: 0 0 8px 8px;
        opacity: 0;
        -webkit-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
    }

    .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-item {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 10px 16px;
        color: var(--text_color);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-top: 1px solid #ddd;
        cursor: pointer;
    }

    .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-item label {
        cursor: pointer;
    }

    .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-info {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        color: var(--text_color);
        text-align: center;
        background-color: #e7e7e7;
        padding: 10px;
        border-radius: 0 0 8px 8px;
    }

    .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-info .btn {
        font-size: 12px;
    }

    .mail-wrapper .mail-selection .mail-select.show .mail-input input {
        border-radius: 8px 8px 0 0;
    }

    .mail-wrapper .mail-selection .mail-select.show .mail-results {
        visibility: visible;
        opacity: 1;
    }

    .mail-wrapper .mail-selection .mail-actions {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-top: 25px;
    }

    @media (max-width: 991.98px) {
        .mail-wrapper .mail-selection .mail-actions {
            margin-top: 15px;
        }
    }

    .mail-wrapper .mail-selection .mail-actions .mail-action {
        width: 100%;
        color: var(--text_color);
        padding: 12px 8px;
        font-size: 15px;
        white-space: nowrap;
    }





    @media (max-width: 991.98px) {
        .mail-wrapper .mail-selection .mail-actions .mail-action {
            font-size: 12px;
        }
    }

    @media (max-width: 499.98px) {
        .mail-wrapper .mail-selection .mail-actions .mail-action {
            padding: 7px 5px;
        }
    }

    .mail-wrapper .mail-selection .mail-actions .mail-action:not(:last-child) {
        margin-right: 10px;
    }

    .mail-wrapper .mail-selection .mail-actions .mail-action .mail-action-text {
        margin-left: 5px;
    }

    @media (max-width: 991.98px) {
        .mail-wrapper .mail-selection .mail-actions .mail-action .mail-action-text {
            display: none;
        }
    }

    .ad.ad-v {
        width: 200px;
        height: 600px;
    }

    .ad.ad-h {
        max-width: 720px;
        width: 100%;
        height: 90px;
    }

    .ad.ad-350 {
        max-width: 350px;
        width: 100%;
        height: 250px;
    }

    .ad.ad-250x250 {
        max-width: 280px;
        width: 100%;
        max-height: 250px;
        display: block !important;
    }

    .ad.ad-250xNull {
        max-width: 250px;
        display: block !important;
    }


    .ad.ad-box {
        max-width: 250px;
        width: 100%;
        height: 250px;
    }



    .ad img {
        width: 100%;
        height: 100%;
    }

    .mail-wrapper .ad {
        -ms-flex-negative: 0;
        flex-shrink: 0;
    }

    .viewbox-container .ad {
        -ms-flex-negative: 0;
        flex-shrink: 0;
    }

    .mailbox-container .ad {
        -ms-flex-negative: 0;
        flex-shrink: 0;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #6565652b !important;
        opacity: 1;
    }


    .modal-header {
        border-bottom: 0px solid #dee2e6 !important;

    }

    .btn {
        border-radius: 8px !important;
        border-width: 2px !important;
        -webkit-transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        -o-transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .border-dashes {
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%2365656557' stroke-width='3' stroke-dasharray='10' stroke-dashoffset='0' stroke-linecap='round'/%3e%3c/svg%3e");
        border-radius: 10px;
    }

    .horizontal_auto_slot_1 {
        width: 320px;
        height: 100px;
    }

    @media(min-width: 500px) {
        .horizontal_auto_slot_1 {
            width: 468px;
            height: 60px;
        }
    }

    @media(min-width: 800px) {
        .horizontal_auto_slot_1 {
            width: 728px;
            height: 90px;
        }
    }
</style>

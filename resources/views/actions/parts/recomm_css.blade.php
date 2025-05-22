<style>
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .tab-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .tab-button.active {
        background-color: #f3f4f6;
        font-weight: 500;
    }

    .tab-button:hover:not(.active) {
        background-color: #f9fafb;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #final-tab,
        #final-tab * {
            visibility: visible;
        }

        #final-tab {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print,
        button,
        .tab-button,
        footer,
        nav {
            display: none !important;
        }
    }
</style>
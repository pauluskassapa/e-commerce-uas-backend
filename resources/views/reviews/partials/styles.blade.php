<style>
    .review-page {
        color: #1f2937;
        font-family: Arial, Helvetica, sans-serif;
    }

    .review-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 2px solid #dcfce7;
    }

    .review-heading h2,
    .review-heading h3 {
        margin: 4px 0 0;
        color: #14532d;
        letter-spacing: 0;
    }

    .review-kicker {
        margin: 0;
        color: #16a34a;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .review-count {
        display: flex;
        align-items: baseline;
        gap: 7px;
        min-width: 92px;
        padding: 10px 14px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        background: #f0fdf4;
        color: #15803d;
    }

    .review-count strong {
        font-size: 22px;
    }

    .review-count span {
        font-size: 13px;
    }

    .review-table-shell {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08);
    }

    .review-table {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
    }

    .review-table th,
    .review-table td {
        padding: 14px 16px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }

    .review-table th {
        background: #15803d;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .review-table tr:last-child td {
        border-bottom: 0;
    }

    .review-table tbody tr:hover {
        background: #f0fdf4;
    }

    .review-comment-cell {
        max-width: 340px;
        color: #4b5563;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .review-table td strong {
        color: #166534;
    }

    .review-rating {
        display: inline-flex;
        align-items: center;
        min-width: 48px;
        padding: 5px 9px;
        border: 1px solid #fde68a;
        border-radius: 6px;
        background: #fffbeb;
        color: #92400e;
        font-weight: 700;
    }

    .review-action,
    .review-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        padding: 8px 13px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 700;
    }

    .review-action {
        border: 1px solid #16a34a;
        background: #16a34a;
        color: #ffffff;
        box-shadow: 0 2px 5px rgba(22, 163, 74, 0.2);
    }

    .review-action:hover {
        border-color: #15803d;
        background: #15803d;
    }

    .review-back {
        margin-bottom: 20px;
        border: 1px solid #86efac;
        color: #15803d;
    }

    .review-back:hover {
        background: #f0fdf4;
    }

    .review-empty {
        padding: 34px 16px !important;
        color: #6b7280;
        text-align: center !important;
    }

    .review-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #dcfce7;
    }

    .review-detail-item span,
    .review-reply-meta {
        display: block;
        margin-bottom: 6px;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .review-detail-item strong {
        color: #111827;
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    .review-text {
        margin: 0;
        padding: 18px 0 18px 18px;
        border-left: 4px solid #22c55e;
        background: #f7fee7;
        color: #374151;
        font-size: 16px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .review-replies {
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #bbf7d0;
    }

    .review-replies h3 {
        margin: 0 0 16px;
        letter-spacing: 0;
    }

    .review-reply-row {
        padding: 16px 0;
        border-bottom: 1px solid #dcfce7;
    }

    .review-reply-row:last-child {
        border-bottom: 0;
    }

    .review-reply-row p {
        margin: 0;
        color: #374151;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .review-seller-label {
        display: inline-block;
        margin-left: 8px;
        padding: 3px 7px;
        border-radius: 5px;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    @media (max-width: 700px) {
        .review-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .review-detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .review-count {
            min-width: 0;
        }
    }
</style>

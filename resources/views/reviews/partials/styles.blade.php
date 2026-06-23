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
        border-bottom: 2px solid #e2e8f0;
    }

    .review-heading-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .review-heading h2,
    .review-heading h3 {
        margin: 4px 0 0;
        color: #1e293b;
        letter-spacing: 0;
    }

    .review-kicker {
        margin: 0;
        color: #2563eb;
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
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
        color: #1e293b;
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
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
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
        background: #1e293b;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .review-table tr:last-child td {
        border-bottom: 0;
    }

    .review-table tbody tr:hover {
        background: #f8fafc;
    }

    .review-comment-cell {
        max-width: 340px;
        color: #4b5563;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .review-table td strong {
        color: #1e293b;
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
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.2);
    }

    .review-action:hover {
        border-color: #1d4ed8;
        background: #1d4ed8;
    }

    .review-action-secondary {
        border-color: #cbd5e1;
        background: #ffffff;
        color: #334155;
        box-shadow: none;
    }

    .review-action-secondary:hover {
        border-color: #94a3b8;
        background: #f8fafc;
        color: #1e293b;
    }

    .review-inline-action {
        margin-top: 12px;
    }

    .review-back {
        margin-bottom: 20px;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .review-back:hover {
        background: #f8fafc;
    }

    .review-empty {
        padding: 34px 16px !important;
        color: #6b7280;
        text-align: center !important;
    }

    .review-empty-panel,
    .review-alert {
        padding: 14px 16px;
        border-radius: 8px;
        line-height: 1.5;
    }

    .review-empty-panel {
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
    }

    .review-alert {
        margin-bottom: 18px;
        font-weight: 700;
    }

    .review-alert-success {
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #15803d;
    }

    .review-alert-error {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .review-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
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
        border-left: 4px solid #2563eb;
        background: #f8fafc;
        color: #374151;
        font-size: 16px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .review-replies {
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .review-replies h3 {
        margin: 0 0 16px;
        letter-spacing: 0;
    }

    .review-reply-row {
        padding: 16px 0;
        border-bottom: 1px solid #e5e7eb;
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

    .review-form {
        display: grid;
        gap: 16px;
        max-width: 720px;
        padding: 20px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }

    .review-form-spaced {
        margin-top: 20px;
    }

    .review-form label {
        display: grid;
        gap: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .review-form select,
    .review-form textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #1f2937;
        font: inherit;
    }

    .review-form select {
        min-height: 40px;
        padding: 8px 10px;
    }

    .review-form textarea {
        min-height: 120px;
        padding: 10px 12px;
        resize: vertical;
        line-height: 1.6;
    }

    .review-form select:focus,
    .review-form textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.14);
        outline: none;
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

        .review-heading-actions {
            justify-content: flex-start;
        }

        .review-form {
            padding: 16px;
        }
    }
</style>

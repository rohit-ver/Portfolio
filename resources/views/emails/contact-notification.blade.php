<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Portfolio Message - Rohit Verma</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0b1120;
            color: #f1f5f9;
        }
        .container {
            max-width: 620px;
            margin: 40px auto;
            background: #111827;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 14px 18px;
        }
        .field-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #06b6d4;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 15px;
            color: #f8fafc;
            word-break: break-word;
        }
        .message-box {
            background: rgba(79, 70, 229, 0.08);
            border-left: 4px solid #4f46e5;
            padding: 18px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 15px;
            line-height: 1.6;
            color: #e2e8f0;
            white-space: pre-wrap;
        }
        .actions {
            margin-top: 30px;
            text-align: center;
        }
        .btn-reply {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        .footer {
            background: rgba(0, 0, 0, 0.3);
            padding: 18px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 New Inquiry Received</h1>
            <p>Direct Message from Rohit Verma Portfolio</p>
        </div>
        <div class="content">
            <div class="field">
                <div class="field-label">Sender Name</div>
                <div class="field-value"><strong>{{ $contact->name }}</strong></div>
            </div>

            <div class="field">
                <div class="field-label">Sender Email</div>
                <div class="field-value"><a href="mailto:{{ $contact->email }}" style="color: #38bdf8; text-decoration: none;">{{ $contact->email }}</a></div>
            </div>

            <div class="field">
                <div class="field-label">Subject</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>

            <div class="field">
                <div class="field-label">Inquiry Message</div>
                <div class="message-box">{{ $contact->message }}</div>
            </div>

            <div style="font-size: 12px; color: #64748b; margin-top: 15px; text-align: right;">
                Received at: {{ $contact->created_at->format('M d, Y - h:i A') }} | IP: {{ $contact->ip_address ?? 'N/A' }}
            </div>

            <div class="actions">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" class="btn-reply">
                    Reply to {{ $contact->name }} &rarr;
                </a>
            </div>
        </div>
        <div class="footer">
            Rohit Verma &bull; Full Stack Web Developer (Laravel / PHP)<br>
            <a href="mailto:rohitv3319@gmail.com" style="color: #94a3b8;">rohitv3319@gmail.com</a> &bull; +91 6378156855
        </div>
    </div>
</body>
</html>

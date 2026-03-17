
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 40px 20px;">
<div style="max-width: 500px; margin: 0 auto; background: white; border-radius: 12px; padding: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h1 style="color: #1f2937; font-size: 24px; margin-bottom: 16px;">
        {{ __('Here Is Your Free Book!') }} 🎉
    </h1>

    <p style="color: #4b5563; font-size: 16px; line-height: 1.6;">
        {{ __('Your email has been verified. The PDF is attached to this email. You can also download it using the link below.') }}
    </p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ $downloadUrl }}"
           style="display: inline-block; padding: 14px 32px; background-color: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
            {{ __('Download PDF') }}
        </a>
    </div>

    <p style="color: #9ca3af; font-size: 12px;">
        {{ __('Enjoy your reading!') }}
    </p>
</div>
</body>
</html>
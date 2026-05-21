<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin: 0; padding: 0; background-color: #FDFCF8; color: #2D3748; font-family: Inter, Arial, sans-serif;">
<div style="padding: 32px 20px;">
    <div style="max-width: 560px; margin: 0 auto;">
        <div style="padding: 24px 0; border-bottom: 1px solid #F3F4F6;">
            <a href="{{ route('landing') }}" style="color: #374151; font-family: Georgia, 'Times New Roman', serif; font-size: 22px; font-style: italic; font-weight: 600; text-decoration: none;">
                Reflexiones de Vida
            </a>
        </div>

        <div style="background-color: #FFFFFF; border: 1px solid #F3F4F6; margin-top: 32px; padding: 40px;">
            <p style="margin: 0 0 12px; color: #B8860B; font-family: Georgia, 'Times New Roman', serif; font-size: 15px; font-style: italic;">
                Gracias por confirmar tu correo
            </p>

            <h1 style="margin: 0 0 20px; color: #111827; font-family: Georgia, 'Times New Roman', serif; font-size: 32px; line-height: 1.15; font-weight: 700;">
                Tu libro esta listo
            </h1>

            <p style="margin: 0; color: #4B5563; font-size: 16px; line-height: 1.7;">
                Adjuntamos el PDF a este correo. Tambien puedes descargarlo directamente desde el siguiente enlace.
            </p>

            <div style="margin: 32px 0;">
                <a href="{{ $downloadUrl }}"
                   style="display: inline-block; width: 100%; box-sizing: border-box; padding: 16px 24px; background-color: #B8860B; color: #FFFFFF; text-align: center; text-decoration: none; font-size: 12px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;">
                    Descargar PDF
                </a>
            </div>

            <p style="margin: 0; color: #9CA3AF; font-size: 12px; line-height: 1.6;">
                Que esta lectura sea de bendicion para tu vida.
            </p>
        </div>

        <div style="padding: 28px 0 0; text-align: center; color: #6B7280; font-size: 13px;">
            <p style="margin: 0 0 8px; font-family: Georgia, 'Times New Roman', serif; font-style: italic;">
                "La sabiduria es un arbol de vida a los que de ella echan mano."
            </p>
            <p style="margin: 0;">&copy; {{ date('Y') }} - {{ config('app.name') }}</p>
        </div>
    </div>
</div>
</body>
</html>

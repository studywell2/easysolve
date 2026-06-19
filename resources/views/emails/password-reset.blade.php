<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your EASYSOLVE Password</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Inter', Arial, sans-serif;">

    <!-- Preheader (hidden) -->
    <div style="display: none; max-height: 0; overflow: hidden; opacity: 0;">
        Reset your EASYSOLVE password — click the link to choose a new password.
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; min-height: 100vh;">
        <tr>
            <td align="center" style="padding: 24px;">

                <!-- Email Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%); padding: 32px 24px;" align="center">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 10px; text-align: center; vertical-align: middle;">
                                        <span style="color: #ffffff; font-weight: 800; font-size: 14px;">ES</span>
                                    </td>
                                    <td style="padding-left: 10px;">
                                        <span style="color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: -0.5px;">EASYSOLVE</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 32px;">
                            <h1 style="margin: 0 0 12px; font-size: 24px; color: #1e293b; font-weight: 800;">Reset your password</h1>
                            <p style="margin: 0 0 20px; font-size: 15px; color: #64748b; line-height: 1.7;">
                                Hi {{ $user->first_name ?? 'there' }}, we received a request to reset the password for your EASYSOLVE account.
                            </p>
                            <p style="margin: 0 0 28px; font-size: 15px; color: #475569; line-height: 1.7;">
                                Click the button below to choose a new password. This link will expire in <strong>{{ $expire }} minutes</strong>.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 28px;">
                                        <a href="{{ $url }}" style="display: inline-block; background: #2563eb; color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 12px;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Fallback link -->
                            <p style="margin: 0 0 24px; font-size: 14px; color: #64748b; line-height: 1.7;">
                                If the button doesn't work, copy and paste this link into your browser:
                                <br>
                                <a href="{{ $url }}" style="color: #2563eb; word-break: break-all; font-size: 13px;">{{ $url }}</a>
                            </p>

                            <!-- Info box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">
                                            <strong style="color: #475569;">Didn't request this?</strong>
                                            You can safely ignore this email — your password will remain unchanged and your account stays secure.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 32px;" align="center">
                            <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                                &copy; {{ date('Y') }} EASYSOLVE — Built by <span style="color: #2563eb; font-weight: 600;">WETech Technology</span>
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
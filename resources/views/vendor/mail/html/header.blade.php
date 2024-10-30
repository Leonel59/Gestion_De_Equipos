@props(['url'])

<tr>
    <td class="header" style="background: linear-gradient(135deg, #001f3f, #007f7f); padding: 20px; border-radius: 10px;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none; color: inherit;"> <!-- Cambia color: transparent; a color: inherit; -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 50" style="height: 50px; width: auto;">
                <!-- Fondo decorativo del logo -->
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#003366; stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#00b3b3; stop-opacity:1" />
                    </linearGradient>
                </defs>
                <circle cx="25" cy="25" r="25" fill="url(#grad1)" />
                
                <!-- Texto RecargaVeloz en el logo -->
                <text x="60" y="30" font-size="20" font-family="Arial" font-weight="bold">
                    <tspan fill="#FFFFFF">RecargaVeloz</tspan>
                </text>
            </svg>
        </a>
    </td>
</tr>



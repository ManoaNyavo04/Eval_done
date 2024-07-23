<!DOCTYPE html>
<html>
<head>
    <title>Certificat de Vainqueur</title>
    <style>
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px 40px;
            background: #fff;
            border: 10px solid #ddd;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            color: #444;
            font-weight: bold;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            color: #777;
            font-style: italic;
        }
        .row {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
            font-size: 18px;
        }
        .row label {
            flex: 1;
            font-weight: bold;
            color: #555;
        }
        .row .value {
            flex: 2;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
        .certificate-border {
            border: 5px solid #333;
            padding: 20px;
            border-radius: 10px;
        }
        .certificate-title {
            font-size: 36px;
            color: #222;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .certificate-subtitle {
            font-size: 24px;
            color: #666;
            margin-bottom: 30px;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .signature div {
            text-align: center;
            width: 45%;
            font-size: 16px;
        }
        .signature div.signature-line {
            border-top: 1px solid #555;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate-border">
            <div class="header">
                <h1 class="certificate-title">Certificat de Vainqueur</h1>
                <h2 class="certificate-subtitle">Félicitations à l'équipe</h2>
            </div>

            <div class="row">
                <label for="equipe">Équipe Vainqueur :</label>
                <div class="value">{{ $vainc->nom }}</div>
            </div>

            <div class="row">
                <label for="points">Points Totaux :</label>
                <div class="value">{{ $vainc->points }}</div>
            </div>

            <div class="row">
                <label for="duree">Durée :</label>
                <div class="value">{{ $vainc->duree }}</div>
            </div>

            <div class="row">
                <label for="rang">Rang :</label>
                <div class="value">{{ $vainc->rang }}</div>
            </div>

            <div class="signature">
                <div>
                    <p class="signature-line">Signature du Responsable</p>
                </div>
                <div>
                    <p class="signature-line">Date</p>
                </div>
            </div>

            <div class="footer">
                <p>© {{ date('Y') }} Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html>

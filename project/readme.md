# Street View Public API 
Д.Самдан - 16B1SEAS2873

Street View Publish API нь 360 зурагуудыг Google Street View руу оруулах боломжийг ологдог.

Street View Publish API-ийг HTTP хүсэл гараж чадах багаж төхөөрөмжийг ашиглан хөгжүүлэж болно.

**Урьдчилсан нөхцөл**
1. Google API console орох боломжтой Google хаягтай байна.
2. Google Developers Console-д шинэ төсөл нээж API түлхүүр авах боломжтой болно.
3. Төсөл үүсгэхэд Street View Publish API үйлчилгээ сонгсон байх:
   a. Шинээх үүсэгсэн төсөл рүүгээ орнр
   b. Enabled APIs хуудас руу орж Street View Publish API идэвхтэй байгаа хэсгийг шалгана. Хэрэв үгүй байвал open the API Library руу орж идэхтэй болгно.
4. OAuth2.0 хэрэгжүүлэх талаар [мэдээлэл авах](https://developers.google.com/streetview/publish/authorizing)

**API түлхүүр авах**
Хэн нэвтэрж орсон тухай мэдээлэл шаардлагтай, үүнийг Google Developers Console оор дамжуулан авна.
1. Developers Console-ийн Credentials руу орно
2. API түлхүүр байгаа үед түүний хэрэглэж болно. Үгүй үед шинээр API түлхүүрийг New credentials ээр үүсгэн.

**Access token авах**
1.  [Google Developers](https://developers.google.com/oauthplayground/) OAuth 2.0 руу орох
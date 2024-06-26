---
Title: Как передать картинку по сети через TServerSocket?
Author: TwoK
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как передать картинку по сети через TServerSocket?
==================================================

Да без проблем. Звиняйте, что на сях, но, тем не менее, на Борланд сях.

Со стороны, откуда посылаем (у нас это клиент), пишем:

    TFileStream* str = new TFileStream("M:\\MyFile.jpg",fmOpenRead);
    //ИЛИ, если мы работаем без сохранения (тогда не создается файл)
    TMemoryStream* str = new TMemoryStream ();
    str->Position = 0;
    Image1->Picture->Bitmap->SaveToStream(str);
    //и, наконец, шлем на сервер битмап
    str->Position = 0;
    ClientSocket1->Socket->SendStream(str);

Обратите внимание, не забывайте перед каждой операцией с потоком
устанавливать позицию в 0!!! Иначе получим не то, что хотелось бы

Ну а со стороны приема (у нас это, соответственно, серверсокет), в
событии приема пишем:

    int ibLen = ServerSocket1->Socket->ReceiveLength();
    char* buf= new char[ibLen+1];
    TMemoryStream* str = new TMemoryStream();
    str->Position = 0;
    ServerSocket1->Socket->ReceiveBuf((void*)buf,ibLen);
    str->WriteBuffer((void*)buf,ibLen);
    str->Position = 0;
    Image1->Picture->Bitmap->LoadFromStream(str);
    //или
    str->SaveToFile("M:\\MyFile.jpg");

Ну и ессно, как говорит Bigbrother, сделал дело - вызови деструктор! То
есть почистить за собой надо, не знаю как в Паскале, но в сях мне надо
удалить str и buf.


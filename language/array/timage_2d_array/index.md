---
Title: Как поместить двумерный массив в TImage?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как поместить двумерный массив в TImage?
========================================

Представим, что данные находятся в массиве:

    TestArray : array[0..127, 0..127] of Byte;

Картинка будет иметь размер 128 x 128 точек:

    Image1.Picture.Bitmap.Width := 128; 
    Image1.Picture.Bitmap.Height := 128; 

Вызываем функцию Windows API для формирования BitMap:

    SetBitmapBits(Image1.Picture.Bitmap.Handle, sizeof(TestArray), @TestArray); 
    Image1.Refresh; {для того, чтобы изменения отобразились}

Однако, если вы используете свою палитру, то ее нужно создать.



 

 

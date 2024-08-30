---
Title: Статическая и динамическая загрузка DLL
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Статическая и динамическая загрузка DLL
=======================================

DLL возможно загружать двумя способами:

- статически
- динамически

Давайте создадим простую библиотеку DLL:

Project file name: c:\\example\\exdouble\\exdouble.dpr

    library ExDouble; 
    // my simple dll 
     
    function calc_double ( r: real ): real; stdcall; 
    begin 
         result := r * 2; 
    end; 
     
    exports 
      calc_double index 1; 
     
    end;

Теперь посмотрим, как её можно загружать:

СТАТИЧЕСКАЯ ЗАГРУЗКА DLL
==================

При таком способе загрузки достаточно поместить файл DLL в директорию
приложения или в директорию Windows, или в Windows\\System,
Windows\\Command. Однако, если система не найдёт этого файла в этих
директория, то высветится сообщение об ошибке (DLL не найдена, или
что-то в этом духе).

    unit untMain; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls; 
     
    type 
      TForm1 = class(TForm) 
        Button1: TButton; 
        procedure Button1Click(Sender: TObject); 
      private 
        { Private declarations } 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    function calc_double ( r: real ): real; stdcall; external 'ExDouble.dll'; 
     
    {$R *.DFM} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
         // в окошке сообщения будет цифра 21
         showMessage ( floatToStr ( calc_double ( 10.5 ) ) ); 
    end; 
     
    end. 

ДИНАМИЧЕСКАЯ ЗАГРУЗКА DLL
===================

При динамической загрузке требуется написать немного больше кода.

А вот как это выглядит:

    unit untMain; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls; 
     
    type 
      Tcalc_double = function  ( r: real ): real; 
     
      TForm1 = class(TForm) 
        Button1: TButton; 
        procedure Button1Click(Sender: TObject); 
      private 
        { Private declarations } 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
       hndDLLHandle: THandle; 
       calc_double: Tcalc_double; 
    begin 
         try 
            // загружаем dll динамически
            hndDLLHandle := loadLibrary ( 'ExDouble.dll' ); 
     
            if hndDLLHandle <> 0 then begin 
     
               // получаем адрес функции
               @calc_double := getProcAddress ( hndDLLHandle, 'calc_double' ); 
     
               // если адрес функции найден
               if addr ( calc_double ) <> nil then begin 
                  // показываем результат ( 21...) 
                  showMessage ( floatToStr ( calc_double ( 10.5 ) ) ); 
               end else 
                  // DLL не найдена ("handleable") 
                  showMessage ( 'Function not exists...' ); 
     
            end else 
               // DLL не найдена ("handleable") 
               showMessage ( 'DLL not found...' ); 
     
         finally 
            // liberar 
            freeLibrary ( hndDLLHandle ); 
         end; 
    end; 
     
    end. 


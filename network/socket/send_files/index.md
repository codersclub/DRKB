---
Title: Отправка файлов при помощи TClientSocket / TServerSocket
Author: M K
Date: 01.01.2007
---


Отправка файлов при помощи TClientSocket / TServerSocket
========================================================

Вариант 1:

Source: <https://forum.sources.ru>

На вопрос "Как я могу отправлять файлы через TClientSocket &
TServerSocket?" даём наш ответ :)

    unit Unit1; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      ScktComp, ExtCtrls, StdCtrls; 
     
    type 
      TForm1 = class(TForm) 
        Image1: TImage; 
        Image2: TImage; 
        ClientSocket1: TClientSocket; 
        ServerSocket1: TServerSocket; 
        Button1: TButton; 
        procedure Image1Click(Sender: TObject); 
        procedure FormCreate(Sender: TObject); 
        procedure ClientSocket1Connect(Sender: TObject; 
          Socket: TCustomWinSocket); 
        procedure ServerSocket1ClientRead(Sender: TObject; 
          Socket: TCustomWinSocket); 
        procedure ClientSocket1Read(Sender: TObject; Socket: TCustomWinSocket); 
      private 
        { Private declarations } 
        Reciving: boolean; 
        DataSize: integer; 
        Data: TMemoryStream; 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    procedure TForm1.Image1Click(Sender: TObject); 
    begin 
      // Это процедура для открытия сокета на ПРИЁМ (RECEIVING). 
      // Button1.Click is this procedure as well. 
      ClientSocket1.Active:= true; 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      // Открытие ОТПРАВЛЯЮЩЕГО (SENDING) сокета. 
      ServerSocket1.Active:= true; 
    end; 
     
    procedure TForm1.ClientSocket1Connect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      // Посылаем команду для начала передачи файла. 
      Socket.SendText('send'); 
    end; 
     
    procedure TForm1.ClientSocket1Read(Sender: TObject; 
      Socket: TCustomWinSocket); 
    var 
      s, sl: string; 
    begin 
      s:= Socket.ReceiveText; 
      // Если мы не в режиме приёма: 
      if not Reciving then 
      begin 
        // Теперь нам необходимо получить длину потока данных. 
        SetLength(sl, StrLen(PChar(s))+1); // +1 for the null terminator 
        StrLCopy(@sl[1], PChar(s), Length(sl)-1); 
        DataSize:= StrToInt(sl); 
        Data:= TMemoryStream.Create; 
        // Удаляем информацию о размере из данных. 
        Delete(s, 1, Length(sl)); 
        Reciving:= true; 
      end; 
      // Сохраняем данные в файл, до тех пор, пока не получим все данные. 
      try 
        Data.Write(s[1], length(s)); 
        if Data.Size = DataSize then 
        begin 
          Data.Position:= 0; 
          Image2.Picture.Bitmap.LoadFromStream(Data); 
          Data.Free; 
          Reciving:= false; 
          Socket.Close; 
        end; 
      except 
        Data.Free; 
      end; 
    end; 
     
    procedure TForm1.ServerSocket1ClientRead(Sender: TObject; 
      Socket: TCustomWinSocket); 
    var 
      ms: TMemoryStream; 
    begin 
      // Клиент получает команду на передачу файла. 
      if Socket.ReceiveText = 'send' then 
      begin 
        ms:= TMemoryStream.Create; 
        try 
          // Получаем данные на передачу. 
          Image1.Picture.Bitmap.SaveToStream(ms); 
          ms.Position:= 0; 
          // Добавляем длину данных, чтобы клиент знал, сколько данных будет передано
          // Добавляем #0, чтобы можно было определить, где заканчивается информация о размере. 
          Socket.SendText(IntToStr(ms.Size) + #0); 
          // Посылаем его. 
          Socket.SendStream(ms); 
        except 
          // Итак, осталось освободить поток, если что-то не так. 
          ms.Free; 
        end; 
      end; 
    end; 
     
    end.


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    unit Unit1; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms, 
      Dialogs, ScktComp, StdCtrls; 
     
    type 
      TForm1 = class(TForm) 
        ClientSocket1: TClientSocket; 
        ServerSocket1: TServerSocket; 
        btnTestSockets: TButton; 
        procedure ClientSocket1Read(Sender: TObject; Socket: TCustomWinSocket); 
        procedure FormCreate(Sender: TObject); 
        procedure FormDestroy(Sender: TObject); 
        procedure ClientSocket1Disconnect(Sender: TObject; 
          Socket: TCustomWinSocket); 
        procedure ClientSocket1Connect(Sender: TObject; 
          Socket: TCustomWinSocket); 
        procedure ServerSocket1ClientConnect(Sender: TObject; 
          Socket: TCustomWinSocket); 
        procedure btnTestSocketsClick(Sender: TObject); 
      private 
        FStream: TFileStream; 
        { Private-Deklarationen } 
      public 
        { Public-Deklarationen } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.dfm} 
     
    procedure TForm1.ClientSocket1Read(Sender: TObject; 
      Socket: TCustomWinSocket); 
    var 
      iLen: Integer; 
      Bfr: Pointer; 
    begin 
      iLen := Socket.ReceiveLength; 
      GetMem(Bfr, iLen); 
      try 
        Socket.ReceiveBuf(Bfr^, iLen); 
        FStream.Write(Bfr^, iLen); 
      finally 
        FreeMem(Bfr); 
      end; 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      FStream := nil; 
    end; 
     
    procedure TForm1.FormDestroy(Sender: TObject); 
    begin 
      if Assigned(FStream) then 
      begin 
        FStream.Free; 
        FStream := nil; 
      end; 
    end; 
     
    procedure TForm1.ClientSocket1Disconnect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      if Assigned(FStream) then 
      begin 
        FStream.Free; 
        FStream := nil; 
      end; 
    end; 
     
    procedure TForm1.ClientSocket1Connect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      FStream := TFileStream.Create('c:\temp\test.stream.html', fmCreate or fmShareDenyWrite); 
    end; 
     
    procedure TForm1.ServerSocket1ClientConnect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      Socket.SendStream(TFileStream.Create('c:\temp\test.html', fmOpenRead or fmShareDenyWrite)); 
    end; 
     
    procedure TForm1.btnTestSocketsClick(Sender: TObject); 
    begin 
      ServerSocket1.Active := True; 
      ClientSocket1.Active := True; 
    end; 
     
    end.


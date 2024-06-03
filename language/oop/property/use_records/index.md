---
Title: Использование записей для хранения информации полей
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Использование записей для хранения информации полей
===================================================

Иногда вам нужно сохранить несколько данных в одном классе, как в примере:
все вместе, когда они принадлежат друг другу.
Таким образом, доступ к этой информации из класса
может быть достигнут с помощью объявления свойства.

Это хороший способ «очистить ваш код» и сделать его максимально «логичным».
Вам также, возможно, придется хранить или загружать информацию из вашего класса,
используя файловую или потоковую технологию.
Это можно сделать сразу для записанной информации внутри данного класса.

    { 
      You sometimes wish to store multiple information in a given class like 
      in the example: alltogether when it belongs together. 
      Thus accessing this information from out of the class can be achieved 
      using property declaration. Its a good way to "clean your code" and 
      make it as "logic" as possible. 
      You also may have to store or load information from your class using 
      file or stream technology. This can be done at once for the recorded 
      information from within the given class. 
    }
     
    type
      TPersonRecord = Record
        FirstName: String;
        LastName: String;
        BirthDate: TDate;
      End;
   
    TForm4 = class(TForm)
      Button1: TButton;
      procedure Button1Click(Sender: TObject);
    private
      fActualUser: TPersonRecord;
      ...
      procedure SaveActualUser(S: TFileStream); // it's an example 
      procedure LoadActualUser(S: TFileStream);
       ...
    public
      property FirstName: string read  fActualUser.FirstName
                                 write fActualUser.FirstName;
      property LastName : string read  fActualUser.LastName
                                 write fActualUser.LastName;
      property BirthDate: TDate  read  fActualUser.BirthDate
                                 write fActualUser.BirthDate;
    end;
   
    procedure TForm4.SaveActualUser(S: TFileStream);
    begin
      // All that stuff at once in your Stream 
      S.Write(fActualUser, SizeOf(fActualUser))
    end;
    
    procedure TForm4.LoadActualUser(S: TFileStream);
    begin
      // All that stuff at once back in your class 
      S.Read(fActualUser, SizeOf(fActualUser));
    end;


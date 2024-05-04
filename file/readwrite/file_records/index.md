---
Title: Чтение и запись переменных типа Record
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Чтение и запись переменных типа Record
======================================

**Файл с множеством записей**

Обычно, я использую файл с заголовком, который я затем загружаю в
память, и использую его для поиска необходимой мне записи.

    type
      TSaveHeader = record
        scene: Integer;
        hotspots: LongInt;
        talk: LongInt;
        hype: LongInt;
      end;
     
    var
      SaveHeader: TSaveHeader;
     
    procedure OpenSaveFile(fname: string);
    var
      f: file;
      i: Integer;
    begin
      AssignFile(f, fname);
      Reset(f, 1);
      BlockRead(f, SaveHeader, Sizeof(TSaveHeader));
      { получаем один набор записи }
      Seek(f, SaveHeader.hotspots);
      for i := 1 to 50 do
        BlockRead(f, somevar, sizeof_hotspotrec);
      { и так далее }
      CloseFile(f);
    end;
     
    { предположим, что файл открыт }
     
    procedure GetHotspotRec(index: LongInt; var hotspotrec: THotspot);
    var
      offset: LongInt;
    begin
      offset := SaveHeader.hotspots + index * Sizeof(THotSpot);
      Seek(f, offset);
      BlockRead(f, hotspotrec, Sizeof(THotspot));
    end; 


**Добавление записи в файл:**


    unit apprec_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Label1: TLabel;
        Label2: TLabel;
        Label3: TLabel;
        Edit1: TEdit; // спортсмен
        ComboBox1: TComboBox; // страна
        ComboBox2: TComboBox; // вид спорта
        RadioGroup1: TRadioGroup; // медаль
        Button1: TButton; // кнопка Добавить
        Label5: TLabel;
        Label4: TLabel;
        procedure FormActivate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
      // тип медали
      TKind = (GOLD, SILVER, BRONZE);
     
      // запись файла
      TMedal = record
        country: string[20]; //  страна
        sport: string[20]; //  вид спорта
        person: string[40]; //  спортсмен
        kind: TKind; //  медаль
      end;
     
    var
      Form1: TForm1;
      f: file of TMedal; // файл записей - база данных
     
    implementation
     
    {$R *.DFM}
     
    // активизация формы
     
    procedure TForm1.FormActivate(Sender: TObject);
    var
      resp: word; // ответ пользователя
    begin
      AssignFile(f, 'a:\medals.db');
    {$I-}
      Reset(f); // открыть файл
      Seek(f, FileSize(f)); // указатель записи в конец файла
    {$I+}
      if IOResult = 0
        then button1.enabled := TRUE // теперь кнопка Добавить доступна
      else
      begin
        resp := MessageDlg('Файл базы данных не найден.' +
          'Создать новую БД?', mtInformation, [mbYes, mbNo], 0);
        if resp = mrYes then
        begin
    {$I-}
          rewrite(f);
    {$I+}
          if IOResult = 0
            then button1.enabled := TRUE
          else ShowMessage('Ошибка создания файла БД.');
        end;
      end;
    end;
     
    // щелчок на кнопке Добавить
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      medal: TMedal;
    begin
      with medal do
      begin
        country := ComboBox1.Text;
        sport := ComboBox2.Text;
        person := Edit1.Text;
        case RadioGroup1.ItemIndex of
          0: kind := GOLD;
          1: kind := SILVER;
          2: kind := BRONZE;
        end;
      end;
      write(f, medal); // записать содержимое полей записи в файл
    end;
     
    // завершение работы программы
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      CloseFile(f); // закрыть файл
    end;
     
    end.


**Запись и чтение из файла массива записей:**

Это не очень Delphi-подобно (тем не менее, работа происходит с
действительно паскалевскими записями), но вы можете писать и читать
записи из/в файл, используя паскалевские процедуры для работы с файлами:

    type
      TMyRec = record ;
        Field1: integer;
        Field2: string;
      end;
     
      TMyRecArray = array[0..9] of TMyRec;
     
    var
      MyArray: TMyRecArray;
      MyRec: TMyRec;
      RecFile: file of TMyRec;
     
    begin
      {...здесь должен быть расположен код инициализации MyArray...}
     
      AssignFile(RecFile, 'MYREC.FIL');
      ReWrite(RecFile);
      for i := 0 to 9 do
      begin
        Write(RecFile, MyRec[i]);
      end;
      CloseFile(RecFile);
    end;

Также, вы можете использовать Read() для чтения записи из вашего файла,
и Seek() для перемещения на его конкретную запись (начиная с 0). Для
получения дополнительной информации обратитесь к разделу "I/O
Routines" электронной справки по Delphi.

Если вы хотите делать это с Data Aware компонентами (компонентами для
работы с базами данных), вы должны создать базу данных, где база данных
"records" должна отражать структуру ваших паскалевских записей, при
этом необходимо создать механизмы трансляции данных из одной среды в
другую. Я не готов сейчас сказать вам, как это можно сделать, но, во
всяком случае, всю функциональность можно инкапсулировать в отдельном
специализированном компоненте.

**Запись и чтение из файла массива записей**

    type
      TR=Record
        Name:string[100]; 
        Age:Byte; 
        Income:Real; 
      end; 
    
    var
      f:file of TR; 
      r:TR; 
     
    begin 
      //assign file 
      assignFile(f, 'MyFileName'); 
      //open file 
      if FileExists('MyFileName') then 
        reset(f) 
      else 
        rewrite(f); 
      //чтение 10й записи 
      seek(f,10); 
      read(f,r); 
      //запись 20й записи 
      seek(f, 20); 
      write(f,r); 
      closefile(f); 
    end;




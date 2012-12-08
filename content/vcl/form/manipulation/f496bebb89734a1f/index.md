---
Title: Как использовать форму из DLL?
Date: 01.01.2007
---


Как использовать форму из DLL?
==============================

::: {.date}
01.01.2007
:::

    library Form;
    uses
      Classes,
      Unit1 in 'Unit1.pas' {Form1};
    exports
      CreateMyForm,
      DestroyMyForm;
    end.

Это его Unit1:

    unit Unit1;
     
    interface
     
    // раздел uses и определение класса Form1
     
      procedure CreateMyForm(AppHandle: THandle); stdcall;
      procedure DestroyMyForm; stdcall;
     
    implementation
    {$R *.DFM}
     
    procedure CreateMyForm(AppHandle: THandle);
    begin
      Application.Handle := AppHandle;
      Form1 := TForm1.Create(Application);
      Form1.Show
    end;
     
    procedure DestroyMyForm;
    begin
      Form1.Free;
    end;
     
    end.

Это UnitCall вызывающего EXE-шника:

    unit
      UnitCall;
     
    interface
     
    // раздел uses и определение класса Form1
     
      procedure CreateMyForm(AppHandle: THandle); stdcall; external 'Form.dll';
      procedure DestroyMyForm; stdcall; external 'Form.dll';
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CreateMyForm(Application.Handle);
    end;
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      DestroyMyForm;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>

---
Title: Как динамически прочитать информацию о классе?
Date: 01.01.2007
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как динамически прочитать информацию о классе?
==============================================

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {This only works for classes registered using RegisterClass}
      RegisterClasses([TButton, TForm]);
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CRef: TPersistentClass;
      PTI: PTypeInfo;
      AControl: TControl;
    begin
      CRef := GetClass('TButton');
      if CRef <> nil then
      begin
        AControl := TControl(TControlClass(CRef).Create(Self));
        with AControl do
        begin
          Parent := Self;
          Width := 50;
          Height := 30;
        end;
        Inc(Id);
      end
      else
        MessageDlg('No such class', mtWarning, [mbOk], 0);
    end;


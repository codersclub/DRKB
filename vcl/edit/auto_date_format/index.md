---
Title: Автоматический формат даты в компоненте TEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Автоматический формат даты в компоненте TEdit
=============================================

    procedure TForm1.Edit1Exit(Sender: TObject);
    begin
      if Edit1.Text <> '' then
      begin
        try
          StrToDate(Edit1.Text);
        except
          Edit1.SetFocus;
          MessageBeep(0);
          raise Exception.Create('"' + Edit1.Text
            + '" - некорректная дата');
        end {try};
        Edit1.Text := DateToStr(StrToDate(Edit1.Text));
      end {if};
    end;



---
Title: Как использовать свой диалог ввода пароля BDE?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как использовать свой диалог ввода пароля BDE?
==============================================

    //  .....
    //  .....
      public
        { Public declarations }
        procedure Password(Sender: TObject; var Continue: Boolean);
    //    ...
      end;
     
    var
      FormMain: TFormMain;
     
    implementation
    {$R *.dfm}
     
    procedure TFormMain.Password(Sender: TObject; var Continue: Boolean);
    var
      Passwd: String[15];
    begin
      Passwd := '';
     
      FormPasswd := TFormPasswd.Create(Application);  // Creating dialog
      try
        if (FormPasswd.ShowModal = ID_OK) then begin  // If OK is pressed then get password from edit "edPassword"
          Passwd := FormPasswd.edPasswd.Text
        end
          else begin                                  // If Cancel is pressed then terminate application
            Application.ShowMainForm := False;
            Application.Terminate;
            Exit;
          end;
      finally
        FormPasswd.Free;                              // finally free password form
      end;
     
      Continue := (Passwd > '');
      Session.AddPassword(Passwd);                    // Add password typed to session
    end;
     
    procedure TFormMain.FormCreate(Sender: TObject);
    begin
      ClientDatabase.Session.RemoveAllPasswords;  // Remove all typed passwords from session, so user need type password again in app start
    //  Undocument next row in debug mode. This is for debugging and testing only, so we don't need typing password again and again ...
    //  ClientDatabase.Session.AddPassword('YOUR-PASSWORD');
      ClientDatabase.Session.OnPassword := Password;  // Set OnPassword Event
    end;


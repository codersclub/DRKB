---
Title: Определить, когда TMediaPlayer закончил проигрывание
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Определить, когда TMediaPlayer закончил проигрывание
====================================================


    procedure TForm1.FormCreate(Sender: TObject);
    begin
      MediaPlayer1.Notify   := True;
      MediaPlayer1.OnNotify := NotifyProc;
    end;
    
    procedure TForm1.NotifyProc(Sender: TObject);
    begin
      with Sender as TMediaPlayer do
       begin
        case Mode of
          mpStopped: {do something here};
        end;
        //must set to true to enable next-time notification 
       Notify := True;
      end;
    end;
    
    
    { 
      NOTE that the Notify property resets back to False when a 
      notify event is triggered, so inorder for you to recieve 
      further notify events, you have to set it back to True as in the code. 
      for the MODES available, see the helpfile for MediaPlayer.Mode; 
    }


---
Title: Как сохранить Outlook календарь как website?
Date: 01.01.2007
---


Как сохранить Outlook календарь как website?
============================================

::: {.date}
01.01.2007
:::

    { In Outlook lasst sich ein Kalender als WebSeite speichern. Dazu benotig man
    den "Web Publishing Wizard" download im Microsoft Download Center. }
     
    { In Outlook you can save the calendar as website. For this you need the
    "Web Publishing Wizard" available at Microsoft Download Center. }
     
     
    { Original VB Script: By Sue Mosher, sue @slipstick.com, with input from Ken Slovak and others
    for more Outlook samples, see http://www.slipstick.com/dev/code/index.htm }
     
    { .... }
     
    uses ComObj;
     
    { .... }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var 
      Outlook, NameSpace, TopFolder, CalendarFolder, WebPub: OleVariant;
      sTitle: string;
    begin
      Outlook := CreateOleObject('Outlook.Application');
      WebPub  := CreateOleObject('WebPub.cWebPub');
     
      NameSpace := Outlook.GetNamespace('MAPI');
      TopFolder := NameSpace.Folders[1];
      CalendarFolder := TopFolder.Folders('Kalender');
     
      WebPub.Create('Kalender von AHA', '', False, '01.05.2003', '01.06.2003',
        True, True, 'C:\Temp');
      {
      WebPub.Create method parameters:
                        'sTitle         - Title displayed at the top of the page
                        'sGraphic       - Path to a graphic file to use for BACKGROUND
                        '                 attribute
                        'bUseGraphic    - True=Use 'sGraphic' param, False=Ignore
                        'dtStartDate    - Start of date range to publish
                        'dtEndDate      - End of date range to publish
                        'bDetails       - Publish appointment details
                        'bShowInBrowser - Display in default browser after publishing
                        'sSiteName      - Local path to store published calendar
      }
     
      WebPub  := Unassigned;
      Outlook := Unassigned;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

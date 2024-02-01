---
Title: How to start Outlook
Date: 01.01.2007
ID: 04452
---


How to start Outlook
====================

{Как запустить Outlook}

There are several different ways to start Outlook from your Delphi app.

* Using D5's components 
* Using the type library (early binding) 
* Without using the type library (late binding) You'll notice that just starting up the Outlook application is not enough to get going - you also have to get the namespace and call its Logon method, like this:


You\'ll notice that just starting up the Outlook application is not
enough to get going - you also have to get the namespace and call its
Logon method, like this:

    NmSpace.Logon('', '', False, False);

I\'ve used this line in the following code snippets, but note that you
may have to supply different arguments to this method if you have user
profiles set up on your computer. The Logon method takes four
parameters: the first two, Profile and Password, are self-explanatory.
The third, ShowDialog, lets you display a logon dialog for the user. If
the fourth, NewSession, is set to True, a new MAPI session is started,
rather than connecting to an existing one.

Bear in mind that when you\'ve logged on you still won\'t see Outlook -
until you display a folder, as shown in the following examples.

Using Delphi 5\'s components

Drop an OutlookApplication component on your form. When you want Outlook
to start, use its Connect method:

    var
      NmSpace: NameSpace;
      Folder: MAPIFolder;
    ...
      OutlookApplication1.Connect;
      NmSpace := OutlookApplication1.GetNamespace('MAPI');
      NmSpace.Logon('', '', False, False);
      Folder := NmSpace.GetDefaultFolder(olFolderInbox);
      Folder.Display;

Because of the need to log on to the MAPI namespace when you start,
there isn\'t much point in setting the OutlookApplication\'s AutoConnect
property to True. And setting the ConnectKind property to ckRunningOrNew
is fairly pointless, too - when you automate Outlook, you\'ll always get
a new instance of it - although Outlook itself will use an existing MAPI
session, if there is one.

Once Outlook has started, you can connect other components, such as a
TMailItem, using the ConnectTo method. Here\'s an example:

```
MailItem1.ConnectTo(OutlookApplication1.CreateItem(olMailItem) as MailItem);
```

Opening Outlook (early binding)

Before you can use this method, you must have imported the Outlook type
library (unless you have Delphi 5).

One way of starting Outlook is to try the GetActiveObject call, to get a
running instance of Outlook, but put a call to CoApplication.Create in
an except clause. But except clauses are slow, and can cause problems
within the IDE for people who like Break On Exceptions set to True. The
following code removes the need for a try...except clause, by avoiding
using OleCheck on GetActiveObject in the case when Outlook is not
running.

    uses Windows, ComObj, ActiveX, 
                Outlook_TLB;  // Outlook8; for D5 users    
     
    var 
      Outlook: _Application;  // OutlookApplication; for D5 users
      Unknown: IUnknown; 
      Result: HResult; 
      NmSpace: NameSpace;
      Folder: MAPIFolder;
    begin 
      {$IFDEF VER120}      // Delphi 4
      Outlook := CoApplication_.Create;
      {$ELSE}              // Delphi 5
      Outlook := CoOutlookApplication.Create;
      {$ENDIF}  
     
      NmSpace := Outlook.GetNamespace('MAPI');
      NmSpace.Logon('', '', False, False);
      Folder := NmSpace.GetDefaultFolder(olFolderInbox);
      Folder.Display;
      ...

 

Without using the type library

Automation is so much easier and faster using type libraries (early
binding) that you should avoid managing without if at all possible. But
if you really can\'t, here\'s how to get started:

    var 
      Outlook, NmSpace, Folder: OleVariant; 
    begin 
      Outlook := CreateOleObject('Outlook.Application');    
      NmSpace := Outlook.GetNamespace('MAPI');
      NmSpace.Logon(EmptyParam, EmptyParam, False, True);
      Folder := NmSpace.GetDefaultFolder(olFolderInbox);
      Folder.Display;

 

Back to \'HowDoI\'

>How to close Outlook

Assuming your Outlook application variable is called Outlook, and the
namespace variable you logged on with (see How to start Outlook) is
NmSpace:

      NmSpace.Logoff;
      Outlook.Quit;
      Outlook.Disconnect;    // Using the D5 components
      { or }
      Outlook := nil;        // Early binding with interfaces  
      { or }
      Outlook := Unassigned; // Late binding with variants

Back to \'HowDoI\'

>How to compose an email

In early binding:

    var
      MI: MailItem;
    begin
      MI := Outlook.CreateItem(olMailItem) as MailItem;
      MI.Recipients.Add('Debs@djpate.freeserve.co.uk');
      MI.Subject := 'Greetings, O gorgeous one';
      MI.Body := 'Your web pages fill me with delight';
      MI.Attachments.Add('C:\CreditCardNo.txt', EmptyParam, EmptyParam, EmptyParam);
      MI.Send;

 

In late binding, MI has to be a variant, and it\'s constructed like
this:

    const
      olMailItem = 0;
    var
      MI: Variant;
    begin
      MI := Outlook.CreateItem(olMailItem);

 

The rest of the code is the same as in early binding.

In Outlook 98, you can also send HTML-formatted emails, by assigning the
HTML as a string to the MailItem\'s HTMLBody property instead of the
Body property. But this isn\'t possible with Outlook 97, and so can\'t
be done with the D5 component either, unless you import the type library
for Outlook 98 (MSOutl85.olb).

Unfortunately there doesn\'t seem to be any way to send true
RTF-formatted emails.

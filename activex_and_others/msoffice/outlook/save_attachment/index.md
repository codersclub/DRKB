---
Title: Сохранить вложения OutLook
autor: Patrick Cleys <http://www.dcmedical.org>
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/>
ID: 04456
---


Сохранить вложения OutLook
==========================


    { 
    won’t some backups of your outlook attachments are filtered 
    some incoming log files? here's the function. 
    } 
     
    uses 
    comobj; 
     
    {...} 
     
    function manageattachments(sendersname, attachmentpath: string; 
    maildelete: boolean): boolean; 
    var 
    oapp: variant; 
    ons: variant; 
    ofolder: variant; 
    omsg: variant; 
    atc: variant; 
    attfilename: variant; 
    filename: string; 
    checksender: string; 
    counter: integer; 
    mailcounter: integer; 
    begin 
    try 
    oapp := createoleobject('outlook.application'); 
    try 
    ons := oapp.getnamespace('mapi'); 
    ofolder := ons.getdefaultfolder(6); // foldertypeenum (olfolderinbox) 
    mailcounter := 1; 
    // if there is any email in the inbox 
    if ofolder.items.count > 0 then 
    begin 
    repeat 
    // get the first email 
    omsg := ofolder.items(mailcounter); 
    // check the name or email 
    // use checksender := omsg.subject to search on subject; 
    checksender := omsg.sendername; 
    if checksender = sendersname then 
    // remove this line to backup all your attachments. 
    begin 
    // check how many attachments 
    atc := omsg.attachments.count; 
    if atc > 0 then 
    begin 
    // get all the attachments and save them 
    for counter := 1 to atc do 
    begin 
    attfilename := omsg.attachments.item(counter).filename; 
    //filename := includetrailingbackslash(attachmentpath)+attfilename; {use this line for d5)} 
    filename := attachmentpath + '' + attfilename; 
    omsg.attachments.item(counter).saveasfile(filename); 
    end; 
    end; 
    if maildelete then 
    begin 
    omsg.delete; 
    // there's 1 email less, so mailcounter - 1 
    dec(mailcounter); 
    end; 
    end; 
    // get the next email 
    inc(mailcounter); 
    // do until there is no more email to check 
    until mailcounter > ofolder.items.count; 
    end; 
    finally 
    oapp.quit; 
    end; 
    except 
    result := false; 
    exit; 
    end; 
    result := true; 
    end; 
     
     
    procedure tform1.button1click(sender: tobject); 
    begin 
    // manageattachments(email or name, backup directory, maildelete yes or no) 
    manageattachments('info@cleys.com', 'f:test', false); 
    end; 
     
     
    { 
    warning! 
    all your selected email will be deleted if maildelete = true 
     
    achtung! 
    alle e-mails werden geloscht, wenn maildelete = true ist. 
    }


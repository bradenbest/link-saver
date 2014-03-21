# Link Saver by Braden Best

The Link Saver is a project I made to replace bookmarks and provide a clean UI instead. Cause in my opinion, browser bookmark systems suck.

## What's new?

This version adds paradigms. Although I stubbornly kept with the awful storage model from 1.0.0, along with using regex to edit links, and now paradigms.

...It gets better in the next version.

## More awfulness

This version is just hilariously bad. Here's the list of localStorage entries it takes up

    LSKEY 	  - the "file" under which links are stored, essentially a directory, or paradigm
    LSLIST 	  - list of said files, so I don't forget what I have.
    [LSKEY].x - Paradigm where infinite links can be stored under, the main engine behind this mofo
    [LSKEY]s 	- Tracker var that tells the write loop how many links to write. Also very important to the engine
    af	    	- stands for animation frames; saves the animation pointer for the [+], [~], and [-] buttons
    ex		    - extra options toggle state

And to add to that, the ENTIRE APP IS WRAPPED IN A TRY..CATCH STATEMENT.

Remember when I said `Fatal Error` in the README for 1.0.0-master? Go ahead and make a paradigm called "?" and try to remove it. 

Yep.

I think this version is even _more_ unstable than 1.0.0.



# Firewall Package for Laravel Filament

---

This was written for private use, but I was asked by a friend to make it public.  The
documentation is lacking, but it's pretty simple to understand.  It's missing a job to
clear out the firewall logs after a certain time.  If there's any actual want for the
package, I'll dev it out more. I'd probably add events to catch when an IP is allowed
or blocked.  

Star the package and message me on twitter @chasecmiller if you have any questions or want to take this over.

* Install the package.  
* Run the migrations.
* Add middlewares as necessary.
* Clear routes.
* Resources are available in Filament 2, if installed.

### Middleware
- firewall-log 
  - Tracks all IPs
- firewall-allow-whitelist 
  - Only allows Whitelisted IPs
- firewall-stop-blacklist 
  - Allows all IPs, except those that are blacklisted.
  - 
## Credits

- [Chase C. Miller](https://github.com/chasecmiller)

## License

Copyright &copy; 2022 Chase C. Miller.  All Rights Reserved.
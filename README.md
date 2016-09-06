# DobsonDev Underscores Generator

These are all the files that run [underscores.dobsondev.com](http://underscores.dobsondev.com/). This website allows you to create your own version of [DobsonDev Underscores](https://github.com/SufferMyJoy/dobsondev-underscores) which is a starter WordPress theme based on on [Underscores](http://underscores.me/) with [Foundation](http://foundation.zurb.com/) hooked in.

## About DobsonDev Underscores

This starting WordPress theme is based on [Underscores](http://underscores.me/) with [Foundation](http://foundation.zurb.com/) hooked in for an extremely well rounded front-end framework. The DobsonDev Underscores Generator now allows you to generate your own starter theme simply by filling out a form on [underscores.dobsondev.com](http://underscores.dobsondev.com/).

## How to Use

The DobsonDev Underscores Generator is extremely easy to use. All you have to do is fill out the form on the generator page at [underscores.dobsondev.com](http://underscores.dobsondev.com/). Once you do that you'll be given a download containg a zip of your new starter theme.

This theme is extremely bare bones, but it's meant to be that way. The idea is that it provides an amazing starting place that you can then easily expand to suit your or your client needs. I use this theme when creating new websites for my clients because I would rather not write a theme from scratch every single time.

## Installing for Yourself

If you want to install the DobsonDev Underscores Generator on your own webserver you are more than welcome to do so! You can even use it to modify a theme you've already create if you want to do through the code.

All you have to do to install the generator on your webserver is copy all of the files to your webspace, and then change the owner of the `temp` folder to `apache`. You use the following command to do so:

```bash
chown apache:apache temp/
```

There shouldn't be any files in there when you first download it so you don't have to recursively change the ownership.

### Using your own Theme

If you've created your own starter theme for WordPress, you can definitely change the code around to work with it. All you need to do is change the following line:

```php
file_put_contents( 'temp/master.zip', file_get_contents( 'https://github.com/SufferMyJoy/dobsondev-underscores/archive/master.zip' ) );
```

You have to change the path to my GitHub project for [DobsonDev Underscores](https://github.com/SufferMyJoy/dobsondev-underscores) to your own path. I would highly recommend still using GitHub to host your starter theme so allyou really need to change is the end of the URL and add your own username and project path. Also that code is on line 32 in `index.php`.

I would really recommend everyone try to make their own starting theme. I thought [Underscores](http://underscores.me/) was great but it would be even better with [Foundation](http://foundation.zurb.com/) hooked in, so I made my own version with exactly that. Ever since then I've slowly been modifying the code to make it perfectly suited to me as a developer.

If you make your own starting theme you can have the exact same tailor-made starting theme at your disposal.

## Contributing

I would like to especially thank [Evan Ahlberg](https://github.com/evanahlberg) for his contributions to this project. He coded the original verion of the DobsonDev Underscores Generator and I just modified his code to get it to where it is now.

I'll accept any pull requests that seem useful or fix bugs present (especially if there is a better way to do the shell scripts). You should fork the main repo, create a feature branch, write your changes/fix some bugs and submit a pull request. I'll review the pull request and if it seems like a good change I'll test it out myself and then merge it in.

## License

DobsonDev Underscores Generator is licensed under the MIT License. Please see `LICENSE` for details.
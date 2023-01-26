# Here u can find more helpful informations:

- More info about [internationalization](https://developer.wordpress.org/plugins/internationalization/)
- More info about [localization](https://developer.wordpress.org/plugins/internationalization/localization/)
- Where to get [poedit](https://poedit.net/)
- Where to get [blank pot file](https://github.com/fxbenard/Blank-WordPress-Pot/blob/master/Blank-WordPress.pot)

## How to proceed

- Make sure your theme/plugin can be transaled (chceck localization link)
- Your text domain name have to be spaced by '-' and should be same as name of your theme/plugin
- To localize text, get blank pot file and download poedit
- Rename blank pot name to your text domain name.pot
- Run poedit, find your blank pot and open it, then save it with name of your text-domain-laguage-prefix
- Extract translatable text from source and strat with translating

## internationalization code examples

- Simple example of translatable text

```
__('text', 'textdomain'),
```

- This example will automatically echo your text

```
_e('text', 'textdomain'),
```

- This allows you to insert more info about text which is translated. This helps translators to catch on context

```
_x('text', 'Post type singular name', 'textdomain'),
```

- U can combine translations with some esc functions. Few examples below

```
esc_html__('text', 'textdomain'),
esc_html_e('text', 'textdomain'),
esc_attr_x('text', 'Post type singular name', 'textdomain'),
```

- To localize script chceck [this link](https://developer.wordpress.org/reference/functions/wp_localize_script/)

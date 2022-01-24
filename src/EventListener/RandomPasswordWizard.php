<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\RandomPassword\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\Image;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RandomPasswordWizard
{
    private ScopeMatcher $scopeMatcher;
    private ?Request $request;
    private Packages $packages;

    public function __construct(RequestStack $requestStack, ScopeMatcher $scopeMatcher, Packages $packages)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->scopeMatcher = $scopeMatcher;
        $this->packages = $packages;
    }

    /**
     * @Callback(table="tl_member", target="fields.password.wizard")
     * @Callback(table="tl_user", target="fields.password.wizard")
     */
    public function addWizard(DataContainer $dc): string
    {
        // TODO: add visual feedback that password was copied to clipboard
        return '<style>.wizard .tl_text {width: calc(100% - 48px)}</style>' . Image::getHtml('sync.svg', '', 'title="' . $GLOBALS['TL_LANG']['MSC']['randomPassword'] . '" id="gen_' . $dc->inputName . '"') . '
<script>
    $("gen_' . $dc->inputName . '").addEvent("click", function (e) {
        e.preventDefault();
        const passw = omgopass();
        document.getElementById("ctrl_' . $dc->inputName . '").value = passw;
        navigator.clipboard.writeText(passw);
        $("ctrl_' . $dc->inputName . '").type = "text";
        var toggle = $("pw_' . $dc->inputName . '");
        toggle.store("tip:title", "' . $GLOBALS['TL_LANG']['MSC']['hidePassword'] . '");
        toggle.src = toggle.src.replace("visible.svg", "visible_.svg");
    })
</script>';
    }

    /**
     * Script must be added onload, because the widget can be rendered in AJAX request in some cases.
     *
     * @Callback(table="tl_member", target="config.onload")
     * @Callback(table="tl_user", target="config.onload")
     */
    public function addHeadScript(): void
    {
        if (!$this->scopeMatcher->isBackendRequest($this->request) || $this->request->query->get('act') != 'edit') {
            return;
        }

        $GLOBALS['TL_JAVASCRIPT'][] = $this->packages->getUrl('omgopass.min.js', 'ameotoko_random_password');
    }
}

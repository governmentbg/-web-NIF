<?php

declare(strict_types=1);

namespace nif\modules\site\programs;

use vakata\http\Request;
use vakata\http\Response;
use webadmin\modules\common\crud\CRUDController;

/**
 * @extends CRUDController<\schema\ProgramsEntity,ProgramsService>
 */
class ProgramsController extends CRUDController
{
    public function getArchive(Request $request): Response
    {
        return $this->postArchive($request);
    }
    public function postArchive(Request $request): Response
    {
        $uri = $request->getUrl();
        $id = (int) $uri->getSegment(2);
        $this->service->archiveProgram($id);
        return (new Response(200))
            ->withHeader(
                "Location",
                $request->getUrl()->linkTo($this->session->get($this->moduleName  . '.index', $this->module->getSlug()))
            );
    }
    public function getPublish(Request $request): Response
    {
        return $this->postPublish($request);
    }
    public function postPublish(Request $request): Response
    {
        $uri = $request->getUrl();
        $id = (int) $uri->getSegment(2);
        $this->service->publishProgram($id);
        return (new Response(200))
            ->withHeader(
                "Location",
                $request->getUrl()->linkTo($this->session->get($this->moduleName  . '.index', $this->module->getSlug()))
            );
    }
}

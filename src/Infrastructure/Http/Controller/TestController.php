<?php

namespace MyPrm\GeoZones\Infrastructure\Http\Controller;

use MyPrm\GeoZones\Domain\Builder\CountryBuilder\CountryDataBuilderInterface;
use MyPrm\GeoZones\Domain\Builder\ZonesBuilder\UnM49Builder;
use MyPrm\GeoZones\Infrastructure\Http\Validator\GeoZonesRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    private CountryDataBuilderInterface $countryBuilder;
    private UnM49Builder $m49Builder;

    public function __construct(
        CountryDataBuilderInterface $countryBuilder,
        UnM49Builder                $m49Builder
    ) {
        $this->countryBuilder = $countryBuilder;
        $this->m49Builder = $m49Builder;
    }

    public function __invoke(Request $request)
    {
        $requestParams = GeoZonesRequestValidator::requestParams($request);
        $requestParams['level'] = 'sub-regions';
        $data = json_decode($this->m49Builder->build($requestParams), true);
        return new JsonResponse($data, Response::HTTP_OK);
    }
}

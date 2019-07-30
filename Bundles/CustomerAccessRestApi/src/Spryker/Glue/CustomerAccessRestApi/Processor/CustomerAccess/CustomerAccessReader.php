<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CustomerAccessRestApi\Processor\CustomerAccess;

use Generated\Shared\Transfer\ContentTypeAccessTransfer;
use Spryker\Glue\CustomerAccessRestApi\CustomerAccessRestApiConfig;
use Spryker\Glue\CustomerAccessRestApi\Dependency\Client\CustomerAccessRestApiToCustomerAccessStorageClientInterface;
use Spryker\Glue\CustomerAccessRestApi\Processor\RestResponseBuilder\CustomerAccessRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerAccessReader implements CustomerAccessReaderInterface
{
    /**
     * @var \Spryker\Glue\CustomerAccessRestApi\CustomerAccessRestApiConfig
     */
    protected $customerAccessRestApiConfig;

    /**
     * @var \Spryker\Glue\CustomerAccessRestApi\Dependency\Client\CustomerAccessRestApiToCustomerAccessStorageClientInterface
     */
    protected $customerAccessStorageClient;

    /**
     * @var \Spryker\Glue\CustomerAccessRestApi\Processor\RestResponseBuilder\CustomerAccessRestResponseBuilderInterface
     */
    protected $customerAccessRestResponseBuilder;

    /**
     * @param \Spryker\Glue\CustomerAccessRestApi\CustomerAccessRestApiConfig $customerAccessRestApiConfig
     * @param \Spryker\Glue\CustomerAccessRestApi\Dependency\Client\CustomerAccessRestApiToCustomerAccessStorageClientInterface $customerAccessStorageClient
     * @param \Spryker\Glue\CustomerAccessRestApi\Processor\RestResponseBuilder\CustomerAccessRestResponseBuilderInterface $customerAccessRestResponseBuilder
     */
    public function __construct(
        CustomerAccessRestApiConfig $customerAccessRestApiConfig,
        CustomerAccessRestApiToCustomerAccessStorageClientInterface $customerAccessStorageClient,
        CustomerAccessRestResponseBuilderInterface $customerAccessRestResponseBuilder
    ) {
        $this->customerAccessRestApiConfig = $customerAccessRestApiConfig;
        $this->customerAccessStorageClient = $customerAccessStorageClient;
        $this->customerAccessRestResponseBuilder = $customerAccessRestResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getCustomerAccess(RestRequestInterface $restRequest): RestResponseInterface
    {
        $customerAccessContentTypeResourceType = $this->customerAccessRestApiConfig->getCustomerAccessContentTypeResourceType();
        $customerAccessContentTypeResourceType = $this->filterOutUnrestrictedCustomerAccessResources($customerAccessContentTypeResourceType);

        return $this->customerAccessRestResponseBuilder
            ->createCustomerAccessResponse($customerAccessContentTypeResourceType);
    }

    /**
     * @param array $customerAccessContentTypeResourceType
     *
     * @return array
     */
    protected function filterOutUnrestrictedCustomerAccessResources(array $customerAccessContentTypeResourceType): array
    {
        $authenticatedCustomerAccess = $this->customerAccessStorageClient->getAuthenticatedCustomerAccess();
        foreach ($authenticatedCustomerAccess->getContentTypeAccess() as $contentTypeAccessTransfer) {
            if ($this->isCustomerAccessResourceUnrestricted($contentTypeAccessTransfer, $customerAccessContentTypeResourceType)) {
                unset($customerAccessContentTypeResourceType[$contentTypeAccessTransfer->getContentType()]);
            }
        }

        return $customerAccessContentTypeResourceType;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentTypeAccessTransfer $contentTypeAccessTransfer
     * @param array $customerAccessContentTypeResourceType
     *
     * @return bool
     */
    protected function isCustomerAccessResourceUnrestricted(ContentTypeAccessTransfer $contentTypeAccessTransfer, array $customerAccessContentTypeResourceType): bool
    {
        return !array_key_exists($contentTypeAccessTransfer->getContentType(), $customerAccessContentTypeResourceType) || !$contentTypeAccessTransfer->getIsRestricted();
    }
}

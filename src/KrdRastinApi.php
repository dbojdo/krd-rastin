<?php

namespace Goosfraba\KrdRastin;

interface KrdRastinApi
{
    /**
     * Verifies a consumer PESEL against their name / last name and/or their permanent and/or temporary address
     *
     * @param VerifyConsumerIdentityNumberRequest $request
     * @return VerifyConsumerIdentityNumberResponse
     */
    public function verifyConsumerIdentityNumber(VerifyConsumerIdentityNumberRequest $request): VerifyConsumerIdentityNumberResponse;

    /**
     * Verifies ID Card against given name and PESEL
     *
     * @param VerifyIDCardRequest $request
     * @return VerifyIDCardResponse
     */
    public function verifyIdCard(VerifyIDCardRequest $request): VerifyIDCardResponse;

    /**
     * Verifies if ID Card is cancelled
     * @param VerifyIsIDCardCanceledRequest $request
     * @return VerifyIsIDCardCanceledResponse
     */
    public function verifyIsIdCardCanceled(VerifyIsIDCardCanceledRequest $request): VerifyIsIDCardCanceledResponse;

    /**
     * Verifies if given consumer is alive
     *
     * @param VerifyConsumerIsAliveRequest $request
     * @return VerifyConsumerIsAliveResponse
     */
    public function verifyConsumerIsAlive(VerifyConsumerIsAliveRequest $request): VerifyConsumerIsAliveResponse;
}

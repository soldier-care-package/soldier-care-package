import React from "react";
import Form from "react-bootstrap/Form";
import {SignInForm} from "../../shared/components/main-nav/sign-in/SignInForm";
import Container from "react-bootstrap/Container";

import {RequestForm} from "./RequestForm";


export const Create = () => {
	return (
		<>
			<Container>
				<RequestForm/>
			</Container>
		</>
	)
}

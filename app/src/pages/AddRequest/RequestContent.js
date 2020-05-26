import React from "react";


export const RequestContent = (props) => {
	const {
		status,
		values,
		errors,
		touched,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset,
	} = props;

	return (
		<>


			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
{/*Request Content*/}
				<div className="form-group">
					<label htmlFor="requestContent">Request Content</label>
					<div className="input-group">

						<input
							className="form-control"
							id="requestContent"
							type="request"
							value={values.requestContent}
							placeholder="Description of items in Request"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.requestContent && touched.requestContent && (
							<div className="alert alert-danger">
								{errors.requestContent}
							</div>
						)}
				</div>

				<div className="form-group">
					<label htmlFor="itemUrl">Item Url</label>
					<div className="input-group">

						<input
							className="form-control"
							id="itemUrl"
							type="item"
							value={values.itemUrl}
							placeholder="Enter item Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.itemUrl && touched.itemUrl && (
							<div className="alert alert-danger">
								{errors.itemUrl}
							</div>
						)}
				</div>

{/*Second item*/}
				<div className="form-group">
					<label htmlFor="secondItemUrl">Second Item Url</label>
					<div className="input-group">

						<input
							className="form-control"
							id="secondItemUrl"
							type="item"
							value={values.secondItemUrl}
							placeholder="Enter item Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.secondItemUrl && touched.secondItemUrl && (
							<div className="alert alert-danger">
								{errors.secondItemUrl}
							</div>
						)}
				</div>

{/*3rd Item				*/}
				<div className="form-group">
					<label htmlFor="thirdItemUrl"> Third item Url</label>
					<div className="input-group">

						<input
							className="form-control"
							id="thirdItemUrl"
							type="item"
							value={values.thirdItemUrl}
							placeholder="Enter item Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.thirdItemUrl && touched.thirdItemUrl && (
							<div className="alert alert-danger">
								{errors.thirdItemUrl}
							</div>
						)}
				</div>

				{/*4th ItemUrl*/}
				<div className="form-group">
					<label htmlFor="fourthItemUrl">Fourth item Url</label>
					<div className="input-group">

						<input
							className="form-control"
							id="fourthItemUrl"
							type="item"
							value={values.fourthItemUrl}
							placeholder="Enter item Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.fourthItemUrl && touched.fourthItemUrl && (
							<div className="alert alert-danger">
								{errors.fourthItemUrl}
							</div>
						)}
				</div>

{/*5th Item Url*/}
				<div className="form-group">
					<label htmlFor="fifthItemUrl">Fifth item Url</label>
					<div className="input-group">

						<input
							className="form-control"
							id="fifthItemUrl"
							type="item"
							value={values.fifthItemUrl}
							placeholder="Enter item Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.fifthItemUrl && touched.fifthItemUrl && (
							<div className="alert alert-danger">
								{errors.fifthItemUrl}
							</div>
						)}
				</div>
				<div className="form-group">
					<button className="btn btn-primary m-1 mb-2" type="submit">Submit</button>
					<button className="btn btn-danger m-1 mb-2" onClick={handleReset}
						// disabled={!dirty || isSubmitting}
					>Reset</button>
				</div>
			</form>
			{status && (<div className={status.type}>{status.message}</div>)}

		</>
	)
}
